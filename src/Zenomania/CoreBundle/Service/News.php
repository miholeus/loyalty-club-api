<?php
/**
 * Created by PhpStorm.
 * User: igorvolkov
 * Date: 23.10.17
 * Time: 21:32
 */

namespace Zenomania\CoreBundle\Service;


use Zenomania\ApiBundle\Request\Filter\NewsFilter;
use Zenomania\CoreBundle\Repository\NewsRepository;
use Zenomania\CoreBundle\Entity\News as NewsEntity;

class News
{
    /**
     * @var NewsRepository
     */
    private $newsRepository;

    const LAST_NEWS_LIMIT = 20;

    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    /**
     * @param NewsFilter $filter
     * @return \Zenomania\CoreBundle\Entity\News[]
     */
    public function getNews(NewsFilter $filter)
    {
        return $this->newsRepository->getNews($filter);
    }

    public function updateNews(int $lastVkId, array $data)
    {
        $lastData = $this->getNewsRepository()->getLastNews($lastVkId, self::LAST_NEWS_LIMIT);
        $deleteNews = array();
        $updateNews = array();
        foreach ($lastData as $lastNews) {
            /** @var  NewsEntity $lastNews */
            // Проверяем удалили ли пост
            if (empty($data[$lastNews->getVkId()])) {
                $deleteNews[] = $lastNews;
            } else {
                // Проверяем не был ли пост отредактирован
                /** @var  NewsEntity $news */
                $news = $data[$lastNews->getVkId()];
                if ($news->getText() != $lastNews->getText() || $news->getPhoto() != $lastNews->getPhoto()
                    || $news->getVideo() != $lastNews->getVideo()) {
                    $lastNews->setText($news->getText());
                    $lastNews->setPhoto($news->getPhoto());
                    $lastNews->setVideo($news->getVideo());
                    $lastNews->setUpdatedOn(new \DateTime());

                    $updateNews[] = $lastNews;
                }
                // Удаляем пост который уже есть в бд
                unset($data[$lastNews->getVkId()]);
            }
        }

        // Объединяем новые посты и посты которые нужно отредактировать
        $data = array_merge($data, $updateNews);

        $this->getNewsRepository()->deleteNews($deleteNews);
        $this->getNewsRepository()->saveNews($data);
    }

    public function updateNewsPinned(NewsEntity $newsPinned)
    {
        /** @var NewsEntity $news */
        $news = $this->getNewsRepository()->findOneBy(['vkId' => $newsPinned->getVkId()]);
        if ($news === null) {
            $this->getNewsRepository()->save($newsPinned);
        } elseif ($news->getText() != $newsPinned->getText() || $news->getPhoto() != $newsPinned->getPhoto() || $news->getVideo() != $newsPinned->getVideo()) {
            $news->setUpdatedOn(new \DateTime());
            $this->getNewsRepository()->save($news);
        }
    }

    /**
     * @return NewsRepository
     */
    public function getNewsRepository(): NewsRepository
    {
        return $this->newsRepository;
    }
}