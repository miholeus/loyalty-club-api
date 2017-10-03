<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 03.10.17
 * Time: 11:06
 */

namespace Zenomania\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Zenomania\CoreBundle\Entity\Badge;
use Doctrine\Common\DataFixtures\AbstractFixture;

class LoadBadgeData extends AbstractFixture
    implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $badge = new Badge();

        $badgeHello = clone $badge;
        $badgeHello->setTitle('Приветственный бэйдж');
        $badgeHello->setSort(1);
        $badgeHello->setCode('hello');
        $badgeHello->setPoints(1);
        $badgeHello->setMaxPoints(1);
        $badgeHello->setActive(true);
        $badgeHello->setTypeId($this->getReference('badge-type-user'));
        $manager->persist($badgeHello);

        $badgeProfile = clone $badge;
        $badgeProfile->setTitle('Бэйдж за заполнение анкеты на 100%');
        $badgeProfile->setSort(2);
        $badgeProfile->setCode('profile done');
        $badgeProfile->setPoints(1);
        $badgeProfile->setMaxPoints(7);
        $badgeProfile->setActive(true);
        $badgeProfile->setTypeId($this->getReference('badge-type-user'));
        $manager->persist($badgeProfile);

        $badgeMatch = clone $badge;
        $badgeMatch->setTitle('Посетил первый матч в Центре Волейбола');
        $badgeMatch->setSort(1);
        $badgeMatch->setCode('first match');
        $badgeMatch->setPoints(1);
        $badgeMatch->setMaxPoints(1);
        $badgeMatch->setActive(true);
        $badgeMatch->setTypeId($this->getReference('badge-type-match'));
        $manager->persist($badgeMatch);

        $manager->flush($badgeHello );
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 5;
    }
}