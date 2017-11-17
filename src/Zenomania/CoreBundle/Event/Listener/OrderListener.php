<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 16.11.17
 * Time: 12:41
 */

namespace Zenomania\CoreBundle\Event\Listener;


use Zenomania\CoreBundle\Entity\Order;
use Zenomania\CoreBundle\Event\Order\OrderWasCancelledEvent;
use Zenomania\CoreBundle\Repository\PersonPointsRepository;
use Zenomania\CoreBundle\Repository\ProductRepository;

class OrderListener
{

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var PersonPointsRepository
     */
    private $personPointsRepository;

    public function __construct(ProductRepository $productRepository, PersonPointsRepository $personPointsRepository)
    {
        $this->productRepository = $productRepository;
        $this->personPointsRepository = $personPointsRepository;
    }

    /**
     * @param OrderWasCancelledEvent $event
     */
    public function onOrderWasCancelledEvent(OrderWasCancelledEvent $event)
    {
        /** @var Order $order */
        $order = $event->getArgument('order');
        
        //Возвращаем товар на склад
        $this->getProductRepository()->returnProduct($order);
        //Возвращаем поинты пользователю
        $this->getPersonPointsRepository()->givePointsForCancelledOrder($order);
    }

    /**
     * @return ProductRepository
     */
    public function getProductRepository(): ProductRepository
    {
        return $this->productRepository;
    }

    /**
     * @return PersonPointsRepository
     */
    public function getPersonPointsRepository(): PersonPointsRepository
    {
        return $this->personPointsRepository;
    }
}