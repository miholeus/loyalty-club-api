<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 07.11.17
 * Time: 14:45
 */

namespace Zenomania\CoreBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Zenomania\CoreBundle\Entity\DeliveryType;

class LoadDeliveryType extends AbstractFixture
    implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $deliveryType = new DeliveryType();

        $deliveryType = clone $deliveryType;
        $deliveryType->setTitle('Самовызов');
        $manager->persist($deliveryType);

        $deliveryTypeRussiaPost = clone $deliveryType;
        $deliveryType->setTitle('Почта России');
        $manager->persist($deliveryTypeRussiaPost   );

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 7;
    }
}