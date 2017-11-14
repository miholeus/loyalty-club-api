<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 08.11.17
 * Time: 15:18
 */

namespace Zenomania\CoreBundle\Service;


use Zenomania\CoreBundle\Entity\Order;
use Zenomania\CoreBundle\Repository\OrderCartRepository;
use Zenomania\CoreBundle\Repository\OrderDeliveryRepository;
use Zenomania\CoreBundle\Repository\OrderStatusHistoryRepository;

class OrderService
{
    /**
     * @var OrderCartRepository
     */
    private $orderCartRepository;

    /**
     * @var OrderDeliveryRepository
     */
    private $orderDeliveryRepository;

    /**
     * @var OrderStatusHistoryRepository
     */
    private $orderStatusHistoryRepository;

    public function __construct(
        OrderStatusHistoryRepository $orderStatusHistoryRepository,
        OrderCartRepository $orderCartRepository,
        OrderDeliveryRepository $orderDeliveryRepository
    )
    {
        $this->orderStatusHistoryRepository = $orderStatusHistoryRepository;
        $this->orderCartRepository = $orderCartRepository;
        $this->orderDeliveryRepository = $orderDeliveryRepository;
    }

    public function getOrderData(Order $order)
    {
        return
            [
                'orderStatusHistory' => $this->getOrderStatusHistory($order),
                'orderCart' => $this->getOrderCart($order),
                'orderDelivery' => $this->getOrderDelivery($order),
            ];
    }

    public function getOrderStatusHistory(Order $order)
    {
        return $this->getOrderStatusHistoryRepository()->findBy(['orderId' => $order->getId()]);
    }

    public function getOrderCart(Order $order)
    {
        return $this->getOrderCartRepository()->findBy(['orderId' => $order->getId()]);
    }

    public function getOrderDelivery(Order $order)
    {
        return $this->getOrderDeliveryRepository()->findOneBy(['orderId' => $order->getId()]);
    }

    /**
     * @return OrderCartRepository
     */
    public function getOrderCartRepository(): OrderCartRepository
    {
        return $this->orderCartRepository;
    }

    /**
     * @return OrderDeliveryRepository
     */
    public function getOrderDeliveryRepository(): OrderDeliveryRepository
    {
        return $this->orderDeliveryRepository;
    }

    /**
     * @return OrderStatusHistoryRepository
     */
    public function getOrderStatusHistoryRepository(): OrderStatusHistoryRepository
    {
        return $this->orderStatusHistoryRepository;
    }
}