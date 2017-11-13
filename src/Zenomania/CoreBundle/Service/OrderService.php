<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 08.11.17
 * Time: 15:18
 */

namespace Zenomania\CoreBundle\Service;


use Zenomania\CoreBundle\Entity\Order;
use Zenomania\CoreBundle\Repository\OrderRepository;

class OrderService
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function getOrderData(Order $order)
    {
        return $this->getOrderRepository()->getOrderData($order);
    }

    /**
     * @return OrderRepository
     */
    public function getOrderRepository()
    {
        return $this->orderRepository;
    }
}