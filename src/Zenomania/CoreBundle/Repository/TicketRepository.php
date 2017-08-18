<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 15.08.2017
 * Time: 12:26
 */

namespace Zenomania\CoreBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Zenomania\CoreBundle\Entity\EventAttendance;
use Zenomania\CoreBundle\Entity\EventAttendanceImport;
use Zenomania\CoreBundle\Entity\Ticket;

class TicketRepository extends EntityRepository
{
    /**
     * Возвращает данные по посещению по его номеру
     *
     * @param string $barcode Номер билета
     * @return EventAttendanceImport
     */
    public function findAttendanceByBarcode($barcode)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('u')
            ->from('ZenomaniaCoreBundle:EventAttendanceImport', 'u')
            ->where('u.ticketNumber = :barcode')
            ->setParameter('barcode', $barcode)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    /**
     * Возвращает билет по его номеру
     *
     * @param string $barcode
     * @return Ticket
     */
    public function findTicketByBarcode($barcode)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('u')
            ->from('ZenomaniaCoreBundle:Ticket', 'u')
            ->where('u.number = :barcode')
            ->setParameter('barcode', $barcode)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    /**
     * Возвращает данные по регистрации билета по его номеру
     *
     * @param string $barcode Номер билета
     * @return EventAttendance
     */
    public function findTicketRegistration($barcode)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('ea')
            ->from('ZenomaniaCoreBundle:EventAttendance', 'ea')
            ->innerJoin('ZenomaniaCoreBundle:Ticket', 'tc', 'WITH', 'tc.id = ea.ticketId')
            ->where('tc.number = :barcode')
            ->setParameter('barcode', $barcode)
            ->getQuery();

        return $query->getOneOrNullResult();
    }
}