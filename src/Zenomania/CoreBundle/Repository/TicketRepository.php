<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 15.08.2017
 * Time: 12:26
 */

namespace Zenomania\CoreBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Zenomania\CoreBundle\Entity\EventAttendanceImport;

class TicketRepository extends EntityRepository
{
    /**
     * Возвращает билет по его номеру
     *
     * @param string $barcode Часть имени пользователя
     *
     * @return EventAttendanceImport
     */
    public function findTicketByBarcode($barcode)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('u')
            ->from('ZenomaniaCoreBundle:EventAttendanceImport', 'u')
            ->where('u.ticketNumber = :barcode')
            ->setParameter('barcode', $barcode)
            ->getQuery();

        return $query->getOneOrNullResult();
    }
}