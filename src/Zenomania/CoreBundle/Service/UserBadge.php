<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 09.10.17
 * Time: 15:46
 */

namespace Zenomania\CoreBundle\Service;

use Zenomania\CoreBundle\Entity\PersonPoints;
use Zenomania\ApiBundle\Service\Utils\PeriodConverter;
use Zenomania\CoreBundle\Repository\UserBadgeRepository;
use Zenomania\CoreBundle\Repository\BadgeRepository;
use Zenomania\CoreBundle\Entity\UserBadge as UserBadgeEntity;
use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Entity\Badge;

class UserBadge
{
    /**
     * @var UserBadgeRepository
     */
    private $userBadgeRepository;

    /**
     * @var BadgeRepository
     */
    private $badgeRepository;

    public function __construct(UserBadgeRepository $userBadgeRepository, BadgeRepository $badgeRepository)
    {
        $this->userBadgeRepository = $userBadgeRepository;
        $this->badgeRepository = $badgeRepository;

    }

    /**
     * Add's badge for user's registration
     *
     * @param User $user
     */
    public function giveBadgeForRegistrations(User $user)
    {
        $userBadge = new UserBadgeEntity();

        /** @var \Zenomania\CoreBundle\Entity\Badge $badge */
        $badge = $this->getBadgeRepository()->findOneBy(['code' => Badge::TYPE_REGISTRATION]);

        $userBadge->setUser($user);
        $userBadge->setPoints($badge->getPoints());
        $userBadge->setBadgeId($badge);

        $this->getUserBadgeRepository()->save($userBadge);
    }

    /**
     * Give's user badge for profile completion
     *
     * @param User $user
     * @return null|object
     */
    public function giveBadgeIfProfileCompleted(User $user)
    {
        return $this->getProfileCompletedBadge($user);
    }

    /**
     * @param User $user
     */
    public function giveBadgeForForecast(User $user)
    {
        $userBadge = new UserBadgeEntity();

        /** @var \Zenomania\CoreBundle\Entity\Badge $badge */
        $badge = $this->getBadgeRepository()->findOneBy(['code' => Badge::TYPE_FORECAST_WINNER_MATCH_RESULT]);
        $userBadge->setUser($user);
        $userBadge->setPoints($badge->getPoints());
        $userBadge->setBadgeId($badge);

        $this->getUserBadgeRepository()->save($userBadge);
    }

    /**
     * @param PersonPoints $personPoints
     */
    public function giveBadgeForRepost(PersonPoints $personPoints)
    {
        $userBadge = new UserBadgeEntity();

        /** @var \Zenomania\CoreBundle\Entity\Badge $badge */
        $badge = $this->getBadgeRepository()->findOneBy(['code' => Badge::TYPE_MAKE_REPOST]);
        $userBadge->setUser($personPoints->getUser());
        if ($personPoints->getPoints() < 0) {
            $badge->setPoints($badge->getPoints() * -1);
        }

        $userBadge->setPoints($badge->getPoints());
        $userBadge->setBadgeId($badge);

        $this->getUserBadgeRepository()->save($userBadge);
    }

    /**
     * @param User $user
     * @param string $code
     * @param array $date
     * @internal param string $period
     */
    public function giveBadgeForRatings(User $user, string $code, array $date)
    {
        $userBadge = new UserBadgeEntity();

        /** @var \Zenomania\CoreBundle\Entity\Badge $badge */
        $badge = $this->getBadgeRepository()->findBadge($code, $date);

        $userBadge->setUser($user);
        $userBadge->setPoints($badge->getPoints());
        $userBadge->setBadgeId($badge);

        $this->getUserBadgeRepository()->save($userBadge);
    }


    /**
     * @param User $user
     * @param string $code
     * @param array $date
     * @internal param string $period
     */
    public function giveBadgeForAllAttendanceOfPeriod(User $user, string $code, array $date)
    {
        $userBadge = new UserBadgeEntity();

        /** @var \Zenomania\CoreBundle\Entity\Badge $badge */
        $badge = $this->getBadgeRepository()->findBadge($code, $date);

        $userBadge->setUser($user);
        $userBadge->setPoints($badge->getPoints());
        $userBadge->setBadgeId($badge);

        $this->getUserBadgeRepository()->save($userBadge);
    }

    /**
     * @param User $user
     */
    public function revokeBadgeIfProfileNotCompleted(User $user)
    {
        $userBadge = $this->getProfileCompletedBadge($user);

        if ($userBadge) {
            $this->getUserBadgeRepository()->remove($userBadge);
        }
    }


    /**
     *
     * @param User $user
     */
    public function giveBadgeForFirstAttendance(User $user)
    {
        $userBadge = new UserBadgeEntity();

        /** @var \Zenomania\CoreBundle\Entity\Badge $badge */
        $badge = $this->getBadgeRepository()->findOneBy(['code' => Badge::TYPE_FIRST_ATTENDANCE]);

        $userBadge->setUser($user);
        $userBadge->setPoints($badge->getPoints());
        $userBadge->setBadgeId($badge);

        $this->getUserBadgeRepository()->save($userBadge);
    }

    /**
     *
     * @param User $user
     */
    public function giveBadgeForAttendance(User $user)
    {
        $userBadge = new UserBadgeEntity();

        /** @var \Zenomania\CoreBundle\Entity\Badge $badge */
        $badge = $this->getBadgeRepository()->findOneBy(['code' => Badge::TYPE_ATTENDANCE]);

        $userBadge->setUser($user);
        $userBadge->setPoints($badge->getPoints());
        $userBadge->setBadgeId($badge);

        $this->getUserBadgeRepository()->save($userBadge);
    }

    /**
     * Get's user's profile completed badge
     *
     * @param User $user
     * @return null|object|UserBadgeEntity
     */
    public function getProfileCompletedBadge(User $user)
    {
        /** @var \Zenomania\CoreBundle\Entity\Badge $badge */
        $badge = $this->getBadgeRepository()->findOneBy(['code' => Badge::TYPE_PROFILE_COMPLETED]);

        $userBadge = $this->getUserBadgeRepository()->findOneBy(
            [
                'badgeId' => $badge,
                'user' => $user
            ]
        );

        if(!$userBadge){
            $userBadge = new \Zenomania\CoreBundle\Entity\UserBadge();
            $userBadge->setBadgeId($badge);
            $userBadge->setPoints($badge->getPoints());
            $userBadge->setUser($user);
            $this->getUserBadgeRepository()->save($userBadge);
        }

        return $userBadge;
    }

    public function getTopUser(array $date)
    {
        return $this->getUserBadgeRepository()->getTopUser($date);
    }


    public function getUsersOfAllAttendanceOfPeriod($period,string $badgeCode)
    {
        return $this->getUserBadgeRepository()->getUsersOfAllAttendanceOfPeriod($period, $badgeCode);
    }

    /**
     * @param PersonPoints $personPoints
     * @return null|object|UserBadgeEntity
     */
    public function getForecastBadge(PersonPoints $personPoints)
    {
        /** @var \Zenomania\CoreBundle\Entity\Badge $badge */
        $badge = $this->getBadgeRepository()->findOneBy(['code' => $personPoints->getType()]);

        return $this->getUserBadgeRepository()->findOneBy(
            [
                'badgeId' => $badge,
                'user' => $personPoints->getUser()
            ]
        );
    }


    /**
     * @return UserBadgeRepository
     */
    public function getUserBadgeRepository(): UserBadgeRepository
    {
        return $this->userBadgeRepository;
    }

    /**
     * @return BadgeRepository
     */
    public function getBadgeRepository(): BadgeRepository
    {
        return $this->badgeRepository;
    }
}