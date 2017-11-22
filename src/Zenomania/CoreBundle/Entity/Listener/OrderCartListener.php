<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 22.11.17
 * Time: 9:56
 */

namespace Zenomania\CoreBundle\Entity\Listener;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Zenomania\CoreBundle\Entity\OrderCart;
use Zenomania\CoreBundle\Entity\Product;
use Zenomania\CoreBundle\Entity\Traits\ValidatorTrait;

class OrderCartListener
{
    use ValidatorTrait;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param OrderCart $orderCart
     * @param LifecycleEventArgs $event
     */
    public function prePersist(OrderCart $orderCart, LifecycleEventArgs $event)
    {
        /** @var Product $product */
        $product = $this->container->get('repository.product')->find($orderCart->getProductId()->getId());

        if ($product == null) {
            throw new HttpException(404, "Товар не найден");
        }

        if ($product->getQuantity() < $orderCart->getQuantity()) {
            throw new HttpException(400, "Товар закончился");
        }

        $quantity = $product->getQuantity() - $orderCart->getQuantity();
        $product->setQuantity($quantity);
        /** @var EntityManager $em */
        $em = $event->getObjectManager();
        $em->flush();
    }
}