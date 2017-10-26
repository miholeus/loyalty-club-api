<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 12.10.17
 * Time: 11:26
 */

namespace Zenomania\CoreBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zenomania\ApiBundle\Service\Social\Client\VkontakteClient;
use Zenomania\CoreBundle\Entity\News;
use Zenomania\CoreBundle\Form\Model\PostVkontakte;

class NewsCommand extends ContainerAwareCommand
{
    const COUNT = 20;

    const FILTER = 'owner';

    protected function configure()
    {
        $this->setName('news:vkontakte')
            ->setDescription('Get news from vkontakte');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var VkontakteClient $service */
        $vkClientService = $this->getContainer()->get('api.client.vk');
        $newsService = $this->getContainer()->get('news.service');
        $groupId = $this->getContainer()->getParameter('vk_group_id');
        $token = $this->getContainer()->getParameter('vk_access_token');
        $rows = $vkClientService->getNews($groupId, $token, self::COUNT, self::FILTER);

        $output->writeln(sprintf("<info>Получили %d новостей</info>", count($rows)));
        $posts = [];
        $pinned = null;
        $lastId = 0;
        foreach ($rows as $row) {
            // Пропускаем репосты
            if (!empty($row->copy_history)) {
                continue;
            }
            $post = new PostVkontakte($row);
            $news = News::fromPost($post);

            $output->writeln(sprintf("<info>Получили новость №%d:</info> %s...", $news->getVkId(), mb_substr($news->getText(), 0, 100, 'utf-8')));

            if (!empty($row->is_pinned) && $row->is_pinned) {
                $pinned = $news;
            } else {
                $posts[$news->getVkId()] = $news;
            }
            $lastId = $news->getVkId();
        }
        ksort($posts);

        $output->writeln("<info>Сохраняем новости</info>");

        $newsService->updateNews($lastId, $posts);
        // Закрепленный пост может быть очень старыми, поэтму его првоеряем отдельно
        if ($pinned !== null) {
            $newsService->updateNewsPinned($pinned);
        }

        $output->writeln("<info>Закончили обработку</info>");
    }
}