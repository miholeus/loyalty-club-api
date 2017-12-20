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
     * @param $id
     * @return Ticket
     */
    public function findByExternalId($id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('t')
            ->from('ZenomaniaCoreBundle:Ticket', 't')
            ->where('t.externalId = :id')
            ->setParameter('id', $id)
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
     * Inserts new ticket
     *
     * @param array $data
     * @return int
     */
    public function addIfNotExists(array $data)
    {
        if (null !== ($current = $this->findByExternalId($data['ticket_id']))) {
            return $current->getId();
        }

        if (null !== ($current = $this->findTicketByBarcode($data['barcode']))) {
            // update external id
            $current->setExternalId($data['ticket_id']);
            $this->_em->persist($current);
            $this->_em->flush();
            return $current->getId();
        }

        $conn = $this->getEntityManager()->getConnection();
        $conn->insert($this->getEntityManager()->getClassMetadata('ZenomaniaCoreBundle:Ticket')->getTableName(), [
            'event_id' => $this->findEventByExternalId($data['event_id']),
            'external_id' => $data['ticket_id'],
            'number' => $data['barcode'],
            'seat' => $data['seat'],
            'sector' => $data['sector'],
            'row' => $data['row'],
            'price' => $data['price']
        ]);
        return $conn->lastInsertId('ticket_id_seq');
    }

    /**
     * @param $id
     * @return int|null
     */
    protected function findEventByExternalId($id)
    {
        $repo = $this->getEntityManager()->getRepository('ZenomaniaCoreBundle:Event');
        $event = $repo->findEventByExternalId($id);
        if (null !== $event) {
            return $event->getId();
        }
        return null;
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