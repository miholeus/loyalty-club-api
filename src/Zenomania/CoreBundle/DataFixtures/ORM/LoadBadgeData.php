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
        $badgeHello->setCode(Badge::TYPE_REGISTRATION);
        $badgeHello->setPoints(1);
        $badgeHello->setMaxPoints(1);
        $badgeHello->setActive(true);
        $badgeHello->setTypeId($this->getReference('badge-type-user'));
        $manager->persist($badgeHello);

        $badgeProfile = clone $badge;
        $badgeProfile->setTitle('Бэйдж за заполнение анкеты на 100%');
        $badgeProfile->setSort(2);
        $badgeProfile->setCode(Badge::TYPE_PROFILE_COMPLETED);
        $badgeProfile->setPoints(1);
        $badgeProfile->setMaxPoints(7);
        $badgeProfile->setActive(true);
        $badgeProfile->setTypeId($this->getReference('badge-type-user'));
        $manager->persist($badgeProfile);

        $badgeMatch = clone $badge;
        $badgeMatch->setTitle('Посетил первый матч в Центре Волейбола');
        $badgeMatch->setSort(1);
        $badgeMatch->setCode(Badge::TYPE_VISITED_FIRST_MATCH);
        $badgeMatch->setPoints(1);
        $badgeMatch->setMaxPoints(1);
        $badgeMatch->setActive(true);
        $badgeMatch->setTypeId($this->getReference('badge-type-match'));
        $manager->persist($badgeMatch);

        $badgePredication = clone $badge;
        $badgePredication->setTitle('Угадал общий счёт матча');
        $badgePredication->setSort(1);
        $badgePredication->setCode(Badge::TYPE_FORECAST_WINNER_MATCH_RESULT);
        $badgePredication->setPoints(1);
        $badgePredication->setMaxPoints(1);
        $badgePredication->setActive(true);
        $badgePredication->setTypeId($this->getReference('badge-type-prediction'));
        $manager->persist($badgePredication);

        $badgeRepost = clone $badge;
        $badgeRepost->setTitle('Сделал репост');
        $badgeRepost->setSort(1);
        $badgeRepost->setCode(Badge::TYPE_MAKE_REPOST);
        $badgeRepost->setPoints(1);
        $badgeRepost->setMaxPoints(1);
        $badgeRepost->setActive(true);
        $badgeRepost->setTypeId($this->getReference('badge-type-repost'));
        $manager->persist($badgeRepost);

        $manager->flush();
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