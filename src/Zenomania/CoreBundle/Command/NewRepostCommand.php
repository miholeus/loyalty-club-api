<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 13.10.2017
 * Time: 14:19
 */

namespace Zenomania\CoreBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zenomania\CoreBundle\Entity\SocialAccount;
use Zenomania\CoreBundle\Entity\SocialRepost;
use Zenomania\CoreBundle\Entity\User;

class NewRepostCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this->setName('repost:new')
            ->setDescription('Search for new repost');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("<info>The start search for new repost</info>");

        /** Подключаем все необходимые репозитории и сервисы */
        $socialRepostRepository = $this->getContainer()->get('repository.social_repost_repository');
        $serviceVk = $this->getContainer()->get('api.client.vk');
        $serviceNews = $this->getContainer()->get('news_repost.service');
        $groupId = $this->getContainer()->getParameter('vk_group_id');

        /** Получить список всех постов для проверки */
        $posts = $serviceNews->getAllNewNews();

        foreach ($posts as $post) {
            $output->writeln("Обрабатываем сообщение №" . $post->getVkId());

            if ($serviceNews->checkTimePost($post)) {
                $output->writeln("Перевели новость из новых в подконтролем ");
            }

            $points = $serviceNews->getPoints($post);
            if (0 == $points) {
                $output->writeln("<comment>Пост не содерит хэштега #XXXZEN</comment>");
                continue;
            }

            /** Получить все репосты для заданного поста */
            $reposts = $serviceVk->getReposts($post, $groupId);
            foreach ($reposts as $repost) {
                if ($this->correctIntervalForRepost($repost)) {
                    $output->writeln("<error>Репост сделан позднее нужной даты</error>");
                    continue;
                }

                if ($socialRepostRepository->existsRepost($post, $repost->from_id)) {
                    $output->writeln("<comment>Репост поста уже был учтён</comment>");
                    continue;
                }

                $user = $this->getUserByVkId($repost->from_id);

                if (empty($user)) {
                    $output->writeln("<error>В Zenomania нет участника с id Вконтакте = " . $repost->from_id . "</error>");
                    continue;
                }

                $this->addPointsForRepost($user, $points);
                $params = [
                    'dt' => (new \DateTime())->setTimestamp($repost->date),
                    'news' => $post,
                    'user' => $user,
                    'vkId' => $repost->id
                ];

                $socialRepost = SocialRepost::fromArray($params);
                $socialRepostRepository->save($socialRepost);
                $output->writeln("<info>Засчитали репост участника с id Вконтакте = " . $repost->from_id . "</info>");
            }
        }

        $output->writeln("<info>The end search for new repost</info>");
    }

    /**
     * Добавить пользователю очки за репост
     *
     * @param User $user
     * @param int $points
     * @return \Zenomania\CoreBundle\Entity\PersonPoints
     */
    private function addPointsForRepost(User $user, int $points)
    {
        return $this->getContainer()
            ->get('repository.person_points_repository')
            ->givePointsForRepost($user, $points);
    }

    private function correctIntervalForRepost($repost)
    {
        $interval = $repost->date - $repost->copy_history[0]->date;
        return $interval > 24 * 60 * 60;
    }

    /**
     * Получить профиль пользователя по его id в Вконтакте
     *
     * @param string $id
     * @return null|User
     */
    private function getUserByVkId(string  $id)
    {
        /** @var SocialAccount $socialAccount */
        $socialAccount = $this->getContainer()
            ->get('repository.social_account_repository')
            ->findOneBy([
                'outerId' => $id,
                'network' => SocialAccount::NETWORK_VK
            ]);

        $user = null;
        if (!empty($socialAccount)) {
            $user = $socialAccount->getUser();
        }

        return $user;
    }
}