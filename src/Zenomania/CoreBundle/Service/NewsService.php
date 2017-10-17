<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 17.10.2017
 * Time: 13:44
 */

namespace Zenomania\CoreBundle\Service;


use Doctrine\ORM\EntityManager;
use Zenomania\CoreBundle\Entity\News;
use Zenomania\CoreBundle\Repository\NewsRepository;

class NewsService
{

    /** @var EntityManager */
    private $em;

    /** @var NewsRepository */
    private $newsRepository;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->newsRepository = $em->getRepository('ZenomaniaCoreBundle:News');
    }

    /**
     * @return News[]
     */
    public function getAllNewNews()
    {
        return $this->getNewsRepository()->findAllNewNews();
    }

    /**
     * Проверка времени существования поста, если более 24 часов, то меняем статус
     *
     * @param News $news
     * @return bool
     */
    public function checkTimePost(News $news)
    {
        /** Если пост опубликован более 24 часов назад, то делаем ему статус controlled */
        $postDate = $news->getDt();
        $currentDate = new \DateTime();
        if ($currentDate->diff($postDate)->d >= 1) {
            $news->setStatus(News::STATUS_CONTROLLED);
            $news->setUpdatedOn(new \DateTime());
            $this->getNewsRepository()->save($news);

            return true;
        }

        return false;
    }

    /**
     * @param News $news
     * @return int
     */
    public function getPointsFromText(News $news)
    {
        if (preg_match('/#(\d+)ZEN/', $news->getText(), $matches)) {
            return $matches[1];
        }

        return 0;
    }

    /**
     * @return EntityManager
     */
    public function getEm(): EntityManager
    {
        return $this->em;
    }

    /**
     * @return NewsRepository
     */
    public function getNewsRepository(): NewsRepository
    {
        return $this->newsRepository;
    }
}