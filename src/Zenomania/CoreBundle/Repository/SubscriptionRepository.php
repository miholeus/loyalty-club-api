<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 24.08.2017
 * Time: 16:43
 */

namespace Zenomania\CoreBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Zenomania\CoreBundle\Entity\EventAttendance;
use Zenomania\CoreBundle\Entity\EventAttendanceImport;
use Zenomania\CoreBundle\Entity\Subscription;
use Zenomania\CoreBundle\Form\Model\SubscriptionNumber;

class SubscriptionRepository extends EntityRepository
{

    /**
     * Возвращает данные абонемента по его номеру
     *
     * @param SubscriptionNumber $subNumber
     * @return Subscription
     */
    public function findSubsByNumber(SubscriptionNumber $subNumber)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('u')
            ->from('ZenomaniaCoreBundle:Subscription', 'u')
            ->where('u.number = :code')
            ->andWhere('u.sector = :sector')
            ->andWhere('u.row = :row')
            ->andWhere('u.seat = :seat')
            ->setParameter('code', $subNumber->getCardcode())
            ->setParameter('sector', $subNumber->getSector())
            ->setParameter('row', $subNumber->getRow())
            ->setParameter('seat', $subNumber->getSeat())
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    /**
     * Возвращает данные по посещению по его номеру
     *
     * @param Subscription $sub
     * @return EventAttendanceImport
     */
    public function findAttendance(Subscription $sub)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('u')
            ->from('ZenomaniaCoreBundle:EventAttendanceImport', 'u')
            ->where('u.subscriptionNumber = :code')
            ->setParameter('code', $sub->getMifare())
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    /**
     * Возвращает данные по регистрации абонемента по его номеру
     *
     * @param SubscriptionNumber $subNumber
     * @return EventAttendance|null
     */
    public function findSubscriptionRegistration(SubscriptionNumber $subNumber)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('ea')
            ->from('ZenomaniaCoreBundle:EventAttendance', 'ea')
            ->innerJoin('ZenomaniaCoreBundle:Subscription', 'tc', 'WITH', 'tc.id = ea.subscriptionId')
            ->where('tc.number = :code')
            ->andWhere('tc.sector = :sector')
            ->andWhere('tc.row = :row')
            ->andWhere('tc.seat = :seat')
            ->setParameter('code', $subNumber->getCardcode())
            ->setParameter('sector', $subNumber->getSector())
            ->setParameter('row', $subNumber->getRow())
            ->setParameter('seat', $subNumber->getSeat())
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    /**
     * Возвращает данные абонемента по его mifare
     *
     * @param string $mifare
     * @return Subscription
     */
    public function findSubsByMifare(string $mifare)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('u')
            ->from('ZenomaniaCoreBundle:Subscription', 'u')
            ->where('u.mifare = :mifare')
            ->setParameter('mifare', $mifare)
            ->getQuery();

        return $query->getOneOrNullResult();
    }
    /**
     * @param $id
     * @return Subscription
     */
    public function findByExternalId($id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('s')
            ->from('ZenomaniaCoreBundle:Subscription', 's')
            ->where('s.externalId = :id')
            ->setParameter('id', $id)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    /**
     * @param $code
     * @return Subscription|null
     */
    public function findByCardCode($code)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('s')
            ->from('ZenomaniaCoreBundle:Subscription', 's')
            ->where('s.mifare = :barcode')
            ->setParameter('barcode', $code)
            ->getQuery();

        return $query->getOneOrNullResult();
    }
    /**
     * Inserts new subscription
     *
     * @param array $data
     * @return int
     */
    public function addIfNotExists(array $data)
    {
        if (null !== ($current = $this->findByExternalId($data['sub_id']))) {
            return $current->getId();
        }

        if (null !== ($current = $this->findByCardCode($data['cardcode']))) {
            // update external id
            $current->setExternalId($data['sub_id']);
            $this->_em->persist($current);
            $this->_em->flush();
            return $current->getId();
        }

        $conn = $this->getEntityManager()->getConnection();
        $conn->insert($this->getEntityManager()->getClassMetadata('ZenomaniaCoreBundle:Subscription')->getTableName(), [
            'season_id' => $data['season_id'],
            'external_id' => $data['sub_id'],
            'mifare' => $data['cardcode'],
            'serial' => $data['serial'],
            'number' => $data['number'],
            'seat' => $data['seat'],
            'sector' => $data['sector'],
            'row' => $data['row'],
            'price' => $data['price']
        ]);
        return $conn->lastInsertId('subscription_id_seq');
    }

    /**
     * @param Subscription $subscription
     */
    public function save(Subscription $subscription)
    {
        $this->_em->persist($subscription);
        $this->_em->flush();
    }
}