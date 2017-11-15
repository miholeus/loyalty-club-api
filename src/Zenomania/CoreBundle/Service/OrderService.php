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
use Zenomania\CoreBundle\Repository\PersonPointsRepository;
use Zenomania\CoreBundle\Repository\ProductRepository;

class OrderService
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;

    /**
     * @var PersonPointsRepository
     */
    private $personPointsRepository;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    public function __construct(
        OrderRepository $orderRepository,
        PersonPointsRepository $personPointsRepository,
        ProductRepository $productRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->personPointsRepository = $personPointsRepository;
        $this->productRepository = $productRepository;
    }

    public function getOrderData(Order $order)
    {
        return $this->getOrderRepository()->getOrderData($order);
    }

    public function orderCancelled(Order $order)
    {
        $this->getProductRepository()->returnProduct($order);
        $this->getPersonPointsRepository()->givePointsForCancelledOrder($order);
    }

    /**
     * @return OrderRepository
     */
    public function getOrderRepository()
    {
        return $this->orderRepository;
    }

    /**
     * @return PersonPointsRepository
     */
    public function getPersonPointsRepository()
    {
        return $this->personPointsRepository;
    }

    /**
     * @return ProductRepository
     */
    public function getProductRepository()
    {
        return $this->productRepository;
    }
}