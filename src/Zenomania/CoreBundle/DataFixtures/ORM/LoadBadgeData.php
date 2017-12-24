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
    /**
     * @param ObjectManager $manager
     */
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

        $date = new \DateTime('2017-11-01');

        $badgeTopRatingOfMonth = clone $badge;
        $badgeTopRatingOfMonth->setTitle('Лидер рейтинга за месяц');
        $badgeTopRatingOfMonth->setSort(1);
        $badgeTopRatingOfMonth->setCode(Badge::TYPE_TOP_RATINGS_OF_MONTH);
        $badgeTopRatingOfMonth->setPoints(1);
        $badgeTopRatingOfMonth->setMaxPoints(1);
        $badgeTopRatingOfMonth->setActive(true);
        $badgeTopRatingOfMonth->setDate($date);
        $badgeTopRatingOfMonth->setTypeId($this->getReference('badge-type-top_rating'));
        $manager->persist($badgeTopRatingOfMonth);

        $badgeTopRatingOfSeason = clone $badge;
        $badgeTopRatingOfSeason->setTitle('Лидер рейтинга за сезон');
        $badgeTopRatingOfSeason->setSort(2);
        $badgeTopRatingOfSeason->setCode(Badge::TYPE_TOP_RATINGS_OF_SEASON);
        $badgeTopRatingOfSeason->setPoints(1);
        $badgeTopRatingOfSeason->setMaxPoints(1);
        $badgeTopRatingOfSeason->setActive(true);
        $badgeTopRatingOfSeason->setDate($date);
        $badgeTopRatingOfSeason->setTypeId($this->getReference('badge-type-top_rating'));
        $manager->persist($badgeTopRatingOfSeason);

        $badgeAttendance = clone $badge;
        $badgeAttendance->setTitle('Посетил матч в центре волейбола');
        $badgeAttendance->setSort(2);
        $badgeAttendance->setCode(Badge::TYPE_ATTENDANCE);
        $badgeAttendance->setPoints(1);
        $badgeAttendance->setMaxPoints(1);
        $badgeAttendance->setActive(true);
        $badgeAttendance->setDate($date);
        $badgeAttendance->setTypeId($this->getReference('badge-type-match'));
        $manager->persist($badgeAttendance);

        $date = new \DateTime('2017-11-01');

        $badgeAllAttendanceOfMonth = clone $badge;
        $badgeAllAttendanceOfMonth->setTitle('Посетил все матчи в центре волейбола за ноябрь');
        $badgeAllAttendanceOfMonth->setSort(2);
        $badgeAllAttendanceOfMonth->setCode(Badge::TYPE_FULL_ATTENDANCE_OF_MONTH);
        $badgeAllAttendanceOfMonth->setPoints(1);
        $badgeAllAttendanceOfMonth->setMaxPoints(1);
        $badgeAllAttendanceOfMonth->setActive(true);
        $badgeAllAttendanceOfMonth->setDate($date);
        $badgeAllAttendanceOfMonth->setTypeId($this->getReference('badge-type-match'));
        $manager->persist($badgeAllAttendanceOfMonth);

        $date = new \DateTime('2017-11-01');

        $badgeAllAttendanceOfSeason = clone $badge;
        $badgeAllAttendanceOfSeason->setTitle('Посетил все матчи в центре волейбола за сезон');
        $badgeAllAttendanceOfSeason->setSort(2);
        $badgeAllAttendanceOfSeason->setCode(Badge::TYPE_FULL_ATTENDANCE_OF_SEASON);
        $badgeAllAttendanceOfSeason->setPoints(1);
        $badgeAllAttendanceOfSeason->setMaxPoints(1);
        $badgeAllAttendanceOfSeason->setActive(true);
        $badgeAllAttendanceOfSeason->setDate($date);
        $badgeAllAttendanceOfSeason->setTypeId($this->getReference('badge-type-match'));
        $manager->persist($badgeAllAttendanceOfSeason);

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