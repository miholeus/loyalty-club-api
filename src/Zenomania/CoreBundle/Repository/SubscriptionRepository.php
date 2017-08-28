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
            ->where('u.number = :cardcode')
            ->setParameter('cardcode', $subNumber->getCardcode())
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    public function save(Subscription $subscription)
    {
        $this->_em->persist($subscription);
        $this->_em->flush();
    }
}