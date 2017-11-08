<?php

namespace Zenomania\CoreBundle\Repository;

use Zenomania\CoreBundle\Entity\Order;

/**
 * OrderRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OrderRepository extends \Doctrine\ORM\EntityRepository
{
    public function getOrder(Order $order)
    {
        $em = $this->getEntityManager();

        $select = $em->getConnection()->createQueryBuilder()
            ->select([
                'o.id',
            ])->from($this->getClassMetadata()->getTableName(), 'o')
            ->innerJoin('o', 'order_cart', 'c', 'c.order_id = o.id')
            ->innerJoin('o', 'order_delivery', 'd', 'd.order_id = o.id')
            ->where('o.id = 3');
            //->setParameter('order_id', 3);
        //var_dump($select->getSQL());exit;
        $result = $select->execute()->fetchAll();
        return $result;
    }
}
