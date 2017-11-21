<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 20.11.17
 * Time: 14:19
 */

namespace Zenomania\ApiBundle\Service;


use Doctrine\ORM\EntityManager;
use Zenomania\ApiBundle\Form\Model\Order as OrderModel;
use Zenomania\ApiBundle\Form\Model\OrderDelivery as OrderDeliveryModel;
use Zenomania\CoreBundle\Entity\Order;
use Zenomania\CoreBundle\Entity\OrderCart;
use Zenomania\CoreBundle\Entity\OrderDelivery;
use Zenomania\CoreBundle\Entity\Product;
use Zenomania\CoreBundle\Entity\User;

class OrderService
{

    /** @var EntityManager */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param OrderModel $data
     * @param User $user
     * @return Order
     */
    public function createOrder(OrderModel $data, User $user)
    {
        $order = new Order();

        $order->setNote($data->getNote());
        $order->setUserId($user);
        $orderCarts = $this->parseOrderCarts($data->getOrderCart(), $order);

        $this->getEm()->persist($order);
        $this->getEm()->flush();

        $this->createOrderCarts($orderCarts, $order);
        $this->createOrderDelivery($data->getOrderDelivery(), $order);
        return $order;
    }

    /**
     * @param array $data
     * @param Order $order
     */
    public function createOrderCarts(array $data, Order $order)
    {
        /** @var OrderCart $item */
        foreach ($data as $item) {
            $item->setOrderId($order);
            $this->getEm()->persist($item);
        }
        $this->getEm()->flush();
    }

    /**
     * @param array $data
     * @param Order $order
     * @return array
     * @internal param $orderPrice
     * @internal param $orderCarts
     */
    public function parseOrderCarts(array $data, Order &$order)
    {
        $orderPrice = 0;
        $orderCarts = array();

        /** @var OrderCart $item */
        foreach ($data as $item) {
            /** @var Product $product */
            $product = $this->getEm()->find('ZenomaniaCoreBundle:Product', $item->getProductId());
            $product->setQuantity($item->getQuantity());

            $orderCart = new OrderCart();
            $orderCart->setCreatedAt(new \DateTime());
            $orderCart->setProductId($product);
            $orderCart->setPrice($product->getPrice());
            $orderCart->setQuantity($item->getQuantity());
            $orderCart->setTotalPrice($orderCart->getPrice() * $orderCart->getQuantity());
            $orderPrice += $orderCart->getTotalPrice();
            $orderCarts[] = $orderCart;
        }
        $order->setPrice($orderPrice);

        return $orderCarts;
    }

    /**
     * @param OrderDeliveryModel $orderDeliveryModel
     * @param Order $order
     */
    public function createOrderDelivery(OrderDeliveryModel $orderDeliveryModel, Order $order)
    {
        $orderDelivery = OrderDelivery::fromOrderDeliveryModel($orderDeliveryModel, $order);

        $deliveryType = $this->getEm()->find('ZenomaniaCoreBundle:DeliveryType',
            $orderDeliveryModel->getDeliveryTypeId());

        $orderDelivery->setDeliveryTypeId($deliveryType);

        $this->getEm()->persist($orderDelivery);
        $this->getEm()->flush();
    }

    /**
     * @return EntityManager
     */
    public function getEm()
    {
        return $this->em;
    }
}