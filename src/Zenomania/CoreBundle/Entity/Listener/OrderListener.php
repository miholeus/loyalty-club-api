<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 14.11.17
 * Time: 15:04
 */

namespace Zenomania\CoreBundle\Entity\Listener;


use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Zenomania\CoreBundle\Entity\Exception\ValidatorException;
use Zenomania\CoreBundle\Entity\OrderStatus;
use Zenomania\CoreBundle\Entity\Traits\ValidatorTrait;
use Zenomania\CoreBundle\Entity\Order;
use Zenomania\CoreBundle\Exception;

class OrderListener
{
    use ValidatorTrait;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param Order $order
     * @param LifecycleEventArgs $event
     * @throws Exception
     */
    public function preUpdate(Order $order, LifecycleEventArgs $event)
    {
        $uow = $event->getEntityManager()->getUnitOfWork();
        $entityChangeSet = $uow->getEntityChangeSet($order);

        if (isset($entityChangeSet['statusId'][0])) {
            /** @var OrderStatus $status */
            $status = $entityChangeSet['statusId'][0];
            if ($status->getCode() == OrderStatus::CANCELLED) {
                throw new ValidatorException('Заказ уже отменен, нельзя менять его статус');
            }
        }
    }

    /**
     * @param Order $order
     * @param LifecycleEventArgs $event
     * @throws Exception
     */
    public function postUpdate(Order $order, LifecycleEventArgs $event)
    {
        $uow = $event->getEntityManager()->getUnitOfWork();
        $entityChangeSet = $uow->getEntityChangeSet($order);

        //Отменяем заказ
        $this->orderCancelled($order, $entityChangeSet);
    }

    /**
     * @param Order $order
     * @param array $entityChangeSet
     */
    public function orderCancelled(Order $order,array $entityChangeSet){
        if (isset($entityChangeSet['statusId'][0])) {
            /** @var OrderStatus $statusOld */
            $statusOld = $entityChangeSet['statusId'][0];
            $status = $order->getStatusId();
            if ($status->getCode() == OrderStatus::CANCELLED && $statusOld->getCode() !== OrderStatus::CANCELLED) {
                $service = $this->container->get('order.service');
                $service->orderCancelled($order);
            }
        }
    }
}