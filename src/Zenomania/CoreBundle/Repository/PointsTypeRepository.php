<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 06.10.2017
 * Time: 16:01
 */

namespace Zenomania\CoreBundle\Repository;


use Doctrine\ORM\EntityRepository;

class PointsTypeRepository extends EntityRepository
{

    /**
     * Найти какое количество % соответствует данному типу и интервалу времени
     *
     * @param string $type
     * @param int $interval
     * @return mixed
     */
    public function findPercentByTypeAndInterval(string $type, int $interval)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('pt.percent')
            ->from('ZenomaniaCoreBundle:PointsType', 'pt')
            ->where('pt.type = :type')
            ->andWhere('pt.interval <= :interval')
            ->setParameter('type', $type)
            ->setParameter('interval', $interval)
            ->orderBy('pt.interval', 'DESC')
            ->setMaxResults(1)
            ->getQuery();

        return $query->getSingleScalarResult();
    }
}