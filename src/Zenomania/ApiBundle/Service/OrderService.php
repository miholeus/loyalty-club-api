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
use Zenomania\CoreBundle\Entity\Order;
use Zenomania\CoreBundle\Entity\OrderCart;
use Zenomania\CoreBundle\Entity\OrderDelivery;
use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Repository\OrderRepository;

class OrderService
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;

    /**
     * @var OrderCartService
     */
    private $orderCartService;

    public function __construct(
        OrderRepository $orderRepository,
        OrderCartService $orderCartService
    ) {
        $this->orderRepository = $orderRepository;
        $this->orderCartService = $orderCartService;
    }

    /**
     * @param OrderModel $data
     * @param User $user
     * @return Order
     */
    public function createOrder(OrderModel $data, User $user)
    {
        $orderCarts = $this->getOrderCartService()->parseOrderCarts($data);
        $orderPrice = 0;
        foreach ($orderCarts as $cart){
            /** @var OrderCart $cart */
            $orderPrice += $cart->getTotalPrice();
        }
        $order = new Order();

        $order->setNote($data->getNote());
        $order->setUserId($user);
        $order->setPrice($orderPrice);

        $deliveryTypeId = $data->getOrderDelivery()->getDeliveryTypeId();

        $orderDelivery = OrderDelivery::fromOrderDeliveryModel($data->getOrderDelivery(), $order);

        $this->getOrderRepository()->createOrder($order, $orderCarts, $orderDelivery, $deliveryTypeId);

        return $order;
    }

    /**
     * @return OrderRepository
     */
    public function getOrderRepository()
    {
        return $this->orderRepository;
    }

    /**
     * @return OrderCartService
     */
    public function getOrderCartService()
    {
        return $this->orderCartService;
    }
}