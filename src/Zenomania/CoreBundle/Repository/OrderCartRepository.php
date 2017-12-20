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
use Zenomania\CoreBundle\Entity\TicketForZen;

class OrderCartRepository extends EntityRepository
{
    /**
     * @param array $orderCarts
     * @param Order $order
     */
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

            if ($product->getCategoryId()->getTitle() == 'Билеты') {
                /** @var TicketForZen $ticket */
                $ticket = $em->getRepository('ZenomaniaCoreBundle:TicketForZen')->findOneBy(['status' => TicketForZen::TYPE_NOT_USED]);
                if (!$ticket) {
                    throw new HttpException(400, "Билеты закончились");
                }
                $ticket->setStatus(TicketForZen::TYPE_PURCHASED);
                $ticket->setUser($order->getUserId());
            }

            $quantity = $product->getQuantity() - $orderCart->getQuantity();
            $product->setQuantity($quantity);

            $orderCart->setOrderId($order);
            $em->persist($orderCart);
        }
    }

}