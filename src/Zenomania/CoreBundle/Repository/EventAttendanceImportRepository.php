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
use Zenomania\CoreBundle\Entity\EventAttendanceImport;

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
            ->andWhere('u.subscriptionNumber IS NOT NULL')
            ->andWhere('u.person IS NULL')
            ->andWhere('u.price > 0')
            ->setParameter('event', $event)
            ->getQuery();

        return $query->getResult();
    }

    public function save(EventAttendanceImport $event)
    {
        $this->_em->persist($event);
        $this->_em->flush();
    }
}