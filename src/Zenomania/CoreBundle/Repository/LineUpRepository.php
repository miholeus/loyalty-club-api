<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 25.09.2017
 * Time: 12:33
 */

namespace Zenomania\CoreBundle\Repository;


use Doctrine\ORM\EntityRepository;

class LineUpRepository extends EntityRepository
{

    /**
     * Удалить все записи с заданным eventId
     *
     * @param integer $eventId
     * @return mixed
     */
    public function deleteAllByEventId($eventId)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $isDeleted = $qb->delete('ZenomaniaCoreBundle:LineUp', 'lu')
            ->where('lu.event = :id')
            ->setParameter('id', $eventId)
            ->getQuery()
            ->execute();

        return $isDeleted;
    }
}