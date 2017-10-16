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
use Zenomania\CoreBundle\Entity\News;
use Zenomania\CoreBundle\Entity\SocialAccount;
use Zenomania\CoreBundle\Entity\SocialRepost;

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
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $socialRepostRepository = $this->getContainer()->get('repository.social_repost_repository');
        $serviceVk = $this->getContainer()->get('api.client.vk');

        /** Получить список всех постов для проверки */
        $posts = $em->getRepository('ZenomaniaCoreBundle:News')->findBy(['status' => News::STATUS_NEW]);

        foreach ($posts as $post) {
            echo "Обрабатываем сообщение №" . $post->getVkId() . PHP_EOL;

            /** @todo проверить, содержит ли поле $post->getText() значение #XXXZEN */

            /** Получить все репосты для заданного поста */
            $reposts = $serviceVk->getReposts($post);
            foreach ($reposts as $repost) {
                $interval = $repost->date - $repost->copy_history[0]->date;
                if ($interval > 24 * 60 * 60) {
                    echo "Репост сделан позднее нужной даты" . PHP_EOL;
                    continue;
                }

                if ($socialRepostRepository->existsRepost($post, $repost->from_id)) {
                    echo "Репост поста уже был учтён" . PHP_EOL;
                    continue;
                }

                $socialAccount = $em->getRepository('ZenomaniaCoreBundle:SocialAccount')->findOneBy(['outerId' => $repost->from_id, 'network' => SocialAccount::NETWORK_VK]);

                $params = [
                    'person' => $socialAccount->getPerson(),
                    'news' => $post,
                    'network' => 'vk',
                    'userOuterid' => $repost->from_id,
                    'repostOuterid' => $repost->id,
                    'repostDt' => $repost->date
                ];

                $socialRepost = SocialRepost::fromArray($params);
                $socialRepostRepository->save($socialRepost);
                echo $repost->to_id . PHP_EOL;
                echo "Интервал времени " . $interval . PHP_EOL;
            }
        }

        // Если еще нет, то добавить информацию о репостах в таблицу
        // При добавлении информации о репосте, начислить баллы пользователю

        // Если с момента опубликования поста прошло более 24 часов, то перевести пост в статус = CHECKED


        $output->writeln("<info>The end search for new repost</info>");
    }
}