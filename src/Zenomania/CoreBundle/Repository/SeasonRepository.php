<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 23.08.2017
 * Time: 15:41
 */

namespace Zenomania\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Zenomania\CoreBundle\Entity\Season;

class SeasonRepository extends EntityRepository
{
    /**
     * Finds current promo action
     *
     * @return Season|null
     */
    public function findCurrentSeason()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('u')
            ->from('ZenomaniaCoreBundle:Season', 'u')
            ->where('u.clubOwner = :club')
            ->orderBy('u.dtStart', 'DESC')
            ->setParameter('club', 9)
            ->setMaxResults(1)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    /**
     * Finds current season
     *
     * @param \DateTime $date
     * @return mixed
     */
    public function findSeasonByDate(\DateTime $date)
    {
        $d = $date->format("Y-m-d H:i:s");
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('u')
            ->from('ZenomaniaCoreBundle:Season', 'u')
            ->where('u.clubOwner = :club')
            ->andWhere('u.dtStart <= :startDate')
            ->andWhere('u.dtEnd > :endDate')
            ->orderBy('u.dtStart', 'DESC')
            ->setParameter('club', 9)
            ->setParameter('startDate', $d)
            ->setParameter('endDate', $d)
            ->setMaxResults(1)
            ->getQuery();

        return $query->getOneOrNullResult();
    }
}