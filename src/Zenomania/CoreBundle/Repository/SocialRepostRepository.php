<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 16.10.2017
 * Time: 16:54
 */

namespace Zenomania\CoreBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Zenomania\CoreBundle\Entity\News;
use Zenomania\CoreBundle\Entity\SocialRepost;

class SocialRepostRepository extends EntityRepository
{

    /**
     * Проверяет, существует ли репост данного поста/новости от данного пользователя
     *
     * @param News $news
     * @param string $userId
     * @return bool
     */
    public function existsRepost(News $news, string $userId)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('sr')
            ->from('ZenomaniaCoreBundle:SocialRepost', 'sr')
            ->innerJoin('ZenomaniaCoreBundle:SocialAccount', 'sa', 'WITH', 'sa.user = sr.user AND sa.network = \'vk\'')
            ->where('sr.news = :news')
            ->andWhere('sa.outerId = :outerid')
            ->setParameter('news', $news)
            ->setParameter('outerid', $userId);

        $query = $qb->getQuery();
        $userList = $query->getResult();

        if (empty($userList)) {
            return false;
        }

        return true;
    }

    /**
     * Получить всех кто сделал репост данной записи
     *
     * @param News $news
     * @return array
     */
    public function findRepostByPost(News $news)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('sa.outerId')
            ->from('ZenomaniaCoreBundle:SocialRepost', 'sr')
            ->innerJoin('ZenomaniaCoreBundle:SocialAccount', 'sa', 'WITH', 'sa.user = sr.user AND sa.network = \'vk\'')
            ->where('sr.news = :news')
            ->setParameter('news', $news);

        $query = $qb->getQuery();
        return $query->getArrayResult();
    }

    public function save(SocialRepost $socialRepost)
    {
        $this->_em->persist($socialRepost);
        $this->_em->flush();
    }

    public function removeRepost(array $id, int $postId)
    {
        $em = $this->getEntityManager();
        $q = $em->createQuery("DELETE FROM Zenomania\CoreBundle\Entity\SocialRepost sr WHERE sr.user_outerid IN (:id) AND sr.news_id = :news");
        $q->setParameter('id', $id);
        $q->setParameter('news', $postId);
        $q->execute();
    }

    public function getPerponPointsForRemove(array $id, int $postId)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('sr.personPoints')
            ->from('ZenomaniaCoreBundle:SocialRepost', 'sr')
            ->where('sr.user_outerid IN (:id)')
            ->andWhere('sr.news_id = :news')
            ->setParameter('news', $id)
            ->setParameter('news', $postId);

        $query = $qb->getQuery();
        return $query->getArrayResult();
    }

    /**
     * Получить все записи о репостах для заданной новости и внешних ВК id пользователей
     *
     * @param array $ids
     * @param News $post
     * @return array
     */
    public function findRepostByPostAndId(array $ids, News $post)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('sr')
            ->from('ZenomaniaCoreBundle:SocialRepost', 'sr')
            ->innerJoin('ZenomaniaCoreBundle:SocialAccount', 'sa', 'WITH', 'sa.user = sr.user AND sa.network = \'vk\'')
            ->where('sr.news = :news')
            ->andWhere('sa.outerId IN (:id)')
            ->setParameter('news', $post)
            ->setParameter('id', $ids);

        $query = $qb->getQuery();
        return $query->getResult();
    }
}