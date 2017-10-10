<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 10.10.2017
 * Time: 17:11
 */

namespace Zenomania\CoreBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Zenomania\CoreBundle\Entity\Event;

class EventAttendanceImportRepository extends EntityRepository
{

    /**
     * Возвращает абонементы, по которым были проходы на заданное мероприятие
     *
     * @param Event $event
     * @return array
     */
    public function findAttendanceByEvent($event)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('u')
            ->from('ZenomaniaCoreBundle:EventAttendanceImport', 'u')
            ->where('u.event = :event')
            ->andWhere('subscription_number IS NOT NULL AND person_id IS NOT NULL')
            ->andWhere('price > 0')
            ->setParameter('event', $event)
            ->getQuery();

        return $query->getResult();
    }
}