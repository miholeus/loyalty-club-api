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
        $service = $this->getContainer()->get('api.client.vk');
        $vk_group_id = $this->getContainer()->getParameter('vk_group_id');
        $vk_access_token = $this->getContainer()->getParameter('vk_access_token');
        $posts = $service->getNews($vk_group_id, $vk_access_token, self::COUNT, self::FILTER);
        $newsArray = array();
        foreach ($posts as $post) {
            // Пропускаем репосты
            if (!empty($post->copy_history)) {
                continue;
            }
            $news = new News();
            $news->setText($post->text);
            $news->setVkId($post->id);
            $news->setDt($post->date);

            // Достаем зены
            $this->parsePoints($news->getText());

            // Парсим теги
            $news->setTags($this->parseTags($post));

            $news->setPhoto($this->parsePhoto($post));
            $news->setVideo($this->parseVideo($post));

            $newsArray[] = $news;
        }
        var_dump($newsArray);
    }

    /**
     * @param $text
     * @return null|integer
     */
    private function parsePoints($text)
    {
        preg_match('/#\d+ZEN/', $text, $pointsTag);
        if ($pointsTag) {
            $pointsTag = array_shift($pointsTag);
            preg_match('/\d/', $pointsTag, $points);
            return array_shift($points);
        }

        return null;
    }

    /**
     * @param object $post
     * @return array
     */
    private function parseTags($post)
    {
        preg_match_all('/#[^\s]+/', $post->text, $matches);

        return json_encode($matches);
    }

    /**
     * @param object $post
     * @return null|string
     */
    private function parsePhoto($post)
    {
        if (!empty($post->attachments)  && is_array($post->attachments)) {
            $attachments = array_shift($post->attachments);
            switch ($attachments->type) {
                case 'photo':
                    $photos = $attachments->photo;
                    break;
                case 'album':
                    $photos = $attachments->album->thumb;
                    break;
                default:
                    return null;
            }

            $sizes = [807, 604, 130, 75];

            foreach ($sizes as $size) {
                $size = 'photo_' . $size;
                if (!empty($photos->$size)) {
                    return $photos->$size;
                }
            }
        }
        return null;
    }

    /**
     * @param object $post
     * @return null|string
     */
    private function parseVideo($post)
    {
        if (!empty($post->attachments) && is_array($post->attachments)) {
            $attachments = array_shift($post->attachments);
            if(!empty($attachments->video))
            {
               return 'https://vk.com/video' . $attachments->video->owner_id . '_' . $attachments->video->id;
            }
        }
        return null;
    }
}