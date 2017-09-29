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
            ->orderBy('u.dtStart', 'DESC')
            ->setMaxResults(1)
            ->getQuery();

        return $query->getOneOrNullResult();
    }
}