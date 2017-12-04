<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 08.11.17
 * Time: 15:18
 */

namespace Zenomania\CoreBundle\Service;


use Zenomania\ApiBundle\Service\OrderCartService;
use Zenomania\CoreBundle\Entity\Order;
use Zenomania\CoreBundle\Repository\OrderRepository;
use Zenomania\CoreBundle\Repository\ProductRepository;
use Zenomania\ApiBundle\Form\Model\Order as OrderModel;
use Zenomania\CoreBundle\Entity\OrderCart;
use Zenomania\CoreBundle\Entity\OrderDelivery;
use Zenomania\CoreBundle\Entity\User;

class OrderService
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var OrderCartService
     */
    private $orderCartService;

    public function __construct(
        OrderRepository $orderRepository,
        ProductRepository $productRepository,
        OrderCartService $orderCartService
    ) {
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
        $this->orderCartService = $orderCartService;
    }

    public function getOrderData(Order $order)
    {
        return $this->getOrderRepository()->getOrderData($order);
    }

    public function orderCancelled(Order $order)
    {
        $this->getProductRepository()->returnProduct($order);
    }


    /**
     * @param OrderModel $data
     * @param \Zenomania\CoreBundle\Entity\User $user
     * @return Order
     */
    public function createOrder(OrderModel $data, \Zenomania\CoreBundle\Entity\User $user)
    {
        $orderCarts = $this->getOrderCartService()->parseOrderCarts($data);
        $orderPrice = 0;
        foreach ($orderCarts as $cart) {
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


    public function getUserOrders(User $user)
    {
        $data = $this->getOrderRepository()->findBy(['userId' => $user->getId()]);
        $orders = array();
        foreach ($data as $item){
            $orderData = array();
            /** @var Order $item */
            $orderData = $this->getOrderData($item);
            $orderData['order'] = $item;
            $orders[] = $orderData;
        }
        return $orders;
    }

    /**
     * @return OrderRepository
     */
    public function getOrderRepository()
    {
        return $this->orderRepository;
    }

    /**
     * @return ProductRepository
     */
    public function getProductRepository()
    {
        return $this->productRepository;
    }

    /**
     * @return OrderCartService
     */
    public function getOrderCartService(): OrderCartService
    {
        return $this->orderCartService;
    }
}