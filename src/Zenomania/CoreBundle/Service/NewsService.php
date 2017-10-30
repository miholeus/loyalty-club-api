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
use Zenomania\CoreBundle\Entity\SocialRepost;
use Zenomania\CoreBundle\Repository\NewsRepository;
use Zenomania\CoreBundle\Repository\SocialRepostRepository;

class NewsService
{

    /** @var EntityManager */
    private $em;

    /** @var NewsRepository */
    private $newsRepository;

    /** @var SocialRepostRepository  */
    private $socialRepostRepository;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->newsRepository = $em->getRepository('ZenomaniaCoreBundle:News');
        $this->socialRepostRepository = $em->getRepository('ZenomaniaCoreBundle:SocialRepost');
    }

    /**
     * @return News[]
     */
    public function getAllNewNews()
    {
        return $this->getNewsRepository()->findAllNewNews();
    }

    /**
     * @return News[]
     */
    public function getAllContlolledNews()
    {
        return $this->getNewsRepository()->findAllControlledNews();
    }

    /**
     * @param News $news
     * @return array
     */
    public function getIdThoseWhoRepost(News $news)
    {
        $reposts = $this->getSocialRepostRepository()->findRepostByPost($news);
        
        if (empty($reposts)) {
            return [];
        }

        $ids = [];
        foreach ($reposts as $repost) {
            $ids[] = $repost['outerId'];
        }

        return $ids;
    }

    /**
     * @param array $ids
     * @param News $post
     */
    public function removeReposts(array $ids, News $post)
    {
        $socialReposts = $this->getSocialRepostRepository()->findRepostByPostAndId($ids, $post);
        foreach ($socialReposts as $repost) {
            $this->getEm()->remove($repost);
            $this->getEm()->flush();
        }
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
    public function getPoints(News $news)
    {
        $points = 0;
        foreach ($news->getTags() as $tag) {
            if (preg_match('/#(\d+)ZEN/', $tag, $matches)) {
                $points += $matches[1];
            }
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

    /**
     * @return SocialRepostRepository
     */
    public function getSocialRepostRepository(): SocialRepostRepository
    {
        return $this->socialRepostRepository;
    }

    /**
     * Проверка времени существования поста, если более 7 дней, то меняем статус
     *
     * @param News $news
     * @return bool
     */
    public function checkTimeControlledPost(News $news)
    {
        /** Если пост опубликован более 7 дней назад, то делаем ему статус done */
        $postDate = $news->getDt();
        $currentDate = new \DateTime();
        if ($currentDate->diff($postDate)->d >= 7) {
            $news->setStatus(News::STATUS_DONE);
            $news->setUpdatedOn(new \DateTime());
            $this->getNewsRepository()->save($news);

            return true;
        }

        return false;
    }
}