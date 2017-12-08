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
use Zenomania\CoreBundle\Entity\BadgeType;
use Doctrine\Common\DataFixtures\AbstractFixture;

class LoadBadgeTypeData extends AbstractFixture
    implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager){
        $badgeType = new BadgeType();

        $badgeTypeUser = clone $badgeType;
        $badgeTypeUser->setTitle('Мои достижения');
        $badgeTypeUser->setSort(1);
        $manager->persist($badgeTypeUser);

        $badgeTypeMatch = clone $badgeType;
        $badgeTypeMatch->setTitle('Матчи');
        $badgeTypeMatch->setSort(2);
        $manager->persist($badgeTypeMatch);

        $badgeTypePrediction = clone $badgeType;
        $badgeTypePrediction->setTitle('Прогнозы');
        $badgeTypePrediction->setSort(3);
        $manager->persist($badgeTypePrediction);

        $badgeTypeRepost = clone $badgeType;
        $badgeTypeRepost->setTitle('Репосты');
        $badgeTypeRepost->setSort(4);
        $manager->persist($badgeTypeRepost);

        $badgeTypeZen = clone $badgeType;
        $badgeTypeZen->setTitle('ZEN');
        $badgeTypeZen->setSort(5);
        $manager->persist($badgeTypeZen);

        $badgeTypeZenomania = clone $badgeType;
        $badgeTypeZenomania->setTitle('Zenomania');
        $badgeTypeZenomania->setSort(6);
        $manager->persist($badgeTypeZenomania);

        $badgeTypeTopRating = clone $badgeType;
        $badgeTypeTopRating->setTitle('Лидер рейтинга');
        $badgeTypeTopRating->setSort(7);
        $manager->persist($badgeTypeTopRating);

        $manager->flush();

        $this->addReference('badge-type-user', $badgeTypeUser);
        $this->addReference('badge-type-match', $badgeTypeMatch);
        $this->addReference('badge-type-prediction', $badgeTypePrediction);
        $this->addReference('badge-type-repost', $badgeTypeRepost);
        $this->addReference('badge-type-zen', $badgeTypeZen);
        $this->addReference('badge-type-zenomania', $badgeTypeZenomania);
        $this->addReference('badge-type-top_rating', $badgeTypeTopRating);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 4;
    }
}