<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 02.11.17
 * Time: 17:21
 */

namespace Zenomania\CoreBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Zenomania\CoreBundle\Entity\OrderStatus;

class LoadOrderStatusData extends AbstractFixture
    implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $orderStatus = new OrderStatus();

        $orderStatusNew = clone $orderStatus;
        $orderStatusNew->setTitle('Новый');
        $orderStatusNew->setCode(OrderStatus::NEW);
        $manager->persist($orderStatusNew);

        $orderStatusInProgress = clone $orderStatus;
        $orderStatusInProgress->setTitle('Принят в работу');
        $orderStatusInProgress->setCode(OrderStatus::IN_PROGRESS);
        $manager->persist($orderStatusInProgress);

        $orderStatusDelivered = clone $orderStatus;
        $orderStatusDelivered->setTitle('Отправлен');
        $orderStatusDelivered->setCode(OrderStatus::DELIVERED);
        $manager->persist($orderStatusDelivered);

        $orderStatusDone = clone $orderStatus;
        $orderStatusDone->setTitle('Завершен');
        $orderStatusDone->setCode(OrderStatus::DONE);
        $manager->persist($orderStatusDone);

        $orderStatusCancelled = clone $orderStatus;
        $orderStatusCancelled->setTitle('Отменен');
        $orderStatusCancelled->setCode(OrderStatus::CANCELLED);
        $manager->persist($orderStatusCancelled);

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 6;
    }
}