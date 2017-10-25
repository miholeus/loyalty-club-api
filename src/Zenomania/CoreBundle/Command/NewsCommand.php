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
        $vk_group_id = $this->getContainer()->getParameter('vk_group_id');
        $vk_access_token = $this->getContainer()->getParameter('vk_access_token');
        $rows = $vkClientService->getNews($vk_group_id, $vk_access_token, self::COUNT, self::FILTER);
        $newsArray = array();
        $newsPinned = null;
        foreach ($rows as $row) {
            // Пропускаем репосты
            if (!empty($row->copy_history)) {
                continue;
            }
            $post = new PostVkontakte($row);
            $news = News::fromPost($post);

            if (!empty($row->is_pinned) && $row->is_pinned) {
                $newsPinned = $news;
            } else {
                $newsArray[$news->getVkId()] = $news;
            }
        }
        ksort($newsArray);
        $newsService->updateNews($news->getVkId(), $newsArray);
        // Закрепленный пост может быть очень старыми, поэтму его првоеряем отдельно
        if ($newsPinned !== null) {
            $newsService->updateNewsPinned($newsPinned);
        }
    }
}