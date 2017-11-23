<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 22.11.17
 * Time: 15:19
 */

namespace Zenomania\CoreBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Zenomania\CoreBundle\Entity\Order;
use Zenomania\CoreBundle\Entity\OrderCart;

class OrderCartRepository extends EntityRepository
{
    public function createOrderCarts(array $orderCarts, Order $order)
    {
        $em = $this->getEntityManager();

        /** @var OrderCart $orderCart */
        foreach ($orderCarts as $orderCart) {
            $product = $em->find('ZenomaniaCoreBundle:Product', $orderCart->getProductId());
            if ($product == null) {
                throw new HttpException(404, "Товар не найден");
            }

            if ($product->getQuantity() < $orderCart->getQuantity()) {
                throw new HttpException(400, "Товар закончился");
            }

            $quantity = $product->getQuantity() - $orderCart->getQuantity();
            $product->setQuantity($quantity);

            $orderCart->setOrderId($order);
            $em->persist($orderCart);
        }
    }

}