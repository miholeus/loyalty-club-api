<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 23.08.2017
 * Time: 15:41
 */

namespace Zenomania\CoreBundle\Repository;


use Doctrine\ORM\EntityRepository;

class PromoActionRepository extends EntityRepository
{

    public function findCurrentSeason()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('u')
            ->from('ZenomaniaCoreBundle:PromoAction', 'u')
            ->orderBy('u.dtStart', 'DESC')
            ->setMaxResults(1)
            ->getQuery();

        return $query->getOneOrNullResult();
    }
}