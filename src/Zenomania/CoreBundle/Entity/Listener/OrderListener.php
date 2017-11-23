<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 14.11.17
 * Time: 15:04
 */

namespace Zenomania\CoreBundle\Entity\Listener;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Zenomania\CoreBundle\Entity\OrderStatus;
use Zenomania\CoreBundle\Entity\OrderStatusHistory;
use Zenomania\CoreBundle\Entity\Traits\UserAwareTrait;
use Zenomania\CoreBundle\Entity\Traits\ValidatorTrait;
use Zenomania\CoreBundle\Entity\Order;
use Zenomania\CoreBundle\Event\NotificationInterface;
use Zenomania\CoreBundle\Event\Order\OrderWasCancelledEvent;
use Zenomania\CoreBundle\Exception;
use Zenomania\CoreBundle\Repository\PersonPointsRepository;
use Zenomania\CoreBundle\Service\Traits\EventsAwareTrait;

class OrderListener
{
    use ValidatorTrait;
    use UserAwareTrait;
    use EventsAwareTrait;

    /**
     * @var NotificationInterface
     */
    protected $notificationManager;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->notificationManager = $container->get('event.notification_manager');
    }

    /**
     * @param Order $order
     * @param LifecycleEventArgs $event
     */
    public function prePersist(Order $order, LifecycleEventArgs $event){
        if($order->getStatusId() == null){
            $orderStatusRepository = $this->container->get('repository.order_status');
            /** @var OrderStatus $status */
            $status = $orderStatusRepository->findOneBy(['code' => OrderStatus::NEW]);
            $order->setStatusId($status);
        }

        //Списываем поинты за заказ
        /** @var PersonPointsRepository $personPointsRepository */
        $personPointsRepository = $this->container->get('repository.person_points_repository');
        $personPointsRepository->takePointsForCreateOrder($order);
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
        /** @var EntityManager $em */
        $em = $event->getObjectManager();

        //Проверяем статус заказа
        $this->checkOrderStatus($order, $entityChangeSet);
        //Пишем в историю статуса
        $this->createOrderStatusHistory($order, $entityChangeSet, $em);
    }

    /**
     * @param Order $order
     * @param array $entityChangeSet
     */
    public function checkOrderStatus(Order $order, array $entityChangeSet)
    {
        if (isset($entityChangeSet['statusId'][0])) {
            /** @var OrderStatus $statusOld */
            $statusOld = $entityChangeSet['statusId'][0];
            $status = $order->getStatusId();
            if ($status->getCode() == OrderStatus::CANCELLED && $statusOld->getCode() !== OrderStatus::CANCELLED) {
                $event = new OrderWasCancelledEvent();
                $event->setArgument('order', $order);
                $this->attachEvent($event);
                $this->updateEvents();
            }
        }
    }

    /**
     * @param Order $order
     * @param array $entityChangeSet
     * @param EntityManager $em
     */
    public function createOrderStatusHistory(Order $order, array $entityChangeSet, EntityManager $em)
    {
        if (isset($entityChangeSet['statusId'][0])) {
            /** @var OrderStatus $statusOld */
            $statusOld = $entityChangeSet['statusId'][0];
            if ($statusOld->getCode() != $order->getStatusId()->getCode()) {
                $orderStatusHistory = new OrderStatusHistory();

                $orderStatusHistory->setOrderId($order);
                $orderStatusHistory->setCreatedBy($this->getUser());
                $orderStatusHistory->setFromOrderStatusId($statusOld);
                $orderStatusHistory->setToOrderStatusId($order->getStatusId());
                $orderStatusHistory->setNote($order->getNote());

                $em->persist($orderStatusHistory);
                $em->flush();
            }
        }
    }
}