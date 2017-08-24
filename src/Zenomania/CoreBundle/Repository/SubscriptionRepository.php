<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 24.08.2017
 * Time: 16:43
 */

namespace Zenomania\CoreBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Zenomania\CoreBundle\Entity\Subscription;

class SubscriptionRepository extends EntityRepository
{

    /**
     * Возвращает данные абонемента по его данные
     *
     * @param string $cardcode
     * @param string $sector
     * @param string $row
     * @param string $seat
     * @return Subscription
     */
    public function findSubsByNumber(string $cardcode, string $sector, string $row, string $seat)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('u')
            ->from('ZenomaniaCoreBundle:Subscription', 'u')
            ->where('u.number = :cardcode')
            ->andWhere('u.sector = :sector')
            ->andWhere('u.row = :row')
            ->andWhere('u.seat = :seat')
            ->setParameter('cardcode', $cardcode)
            ->setParameter('sector', $sector)
            ->setParameter('row', $row)
            ->setParameter('seat', $seat)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    public function save(Subscription $subscription)
    {
        $this->_em->persist($subscription);
        $this->_em->flush();
    }
}