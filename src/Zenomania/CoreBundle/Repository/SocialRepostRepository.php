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
            ->where('sr.news = :news')
            ->andWhere('sr.userOuterid = :user')
            ->setParameter('news', $news)
            ->setParameter('user', $userId);

        $query = $qb->getQuery();
        $userList = $query->getResult();

        if (empty($userList)) {
            return false;
        }

        return true;
    }

    public function save(SocialRepost $socialRepost)
    {
        $this->_em->persist($socialRepost);
        $this->_em->flush();
    }
}