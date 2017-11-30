<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 09.10.17
 * Time: 15:46
 */

namespace Zenomania\CoreBundle\Service;

use Zenomania\CoreBundle\Entity\PersonPoints;
use Zenomania\CoreBundle\Repository\UserBadgeRepository;
use Zenomania\CoreBundle\Repository\BadgeRepository;
use Zenomania\CoreBundle\Entity\UserBadge as UserBadgeEntity;
use Zenomania\CoreBundle\Entity\User;

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
        $badge = $this->getBadgeRepository()->findOneBy(['code' => \Zenomania\CoreBundle\Entity\Badge::TYPE_REGISTRATION]);

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
        $userBadge = $this->getProfileCompletedBadge($user);

        if (!$userBadge) {
            $this->getUserBadgeRepository()->save($userBadge);
        }

        return $userBadge;
    }

    /**
     * @param User $user
     */
    public function giveBadgeForForecast(User $user)
    {
        $userBadge = new UserBadgeEntity();

        /** @var \Zenomania\CoreBundle\Entity\Badge $badge */
        $badge = $this->getBadgeRepository()->findOneBy(['code' => \Zenomania\CoreBundle\Entity\Badge::TYPE_FORECAST_WINNER_MATCH_RESULT]);
        $userBadge->setUser($user);
        $userBadge->setPoints($badge->getPoints());
        $userBadge->setBadgeId($badge);

        $this->getUserBadgeRepository()->save($userBadge);
    }

    /**
     * @param User $user
     */
    public function giveBadgeForRepost(User $user)
    {
        $userBadge = new UserBadgeEntity();

        /** @var \Zenomania\CoreBundle\Entity\Badge $badge */
        $badge = $this->getBadgeRepository()->findOneBy(['code' => \Zenomania\CoreBundle\Entity\Badge::TYPE_MAKE_REPOST]);
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
     * Get's user's profile completed badge
     *
     * @param User $user
     * @return null|object|UserBadgeEntity
     */
    public function getProfileCompletedBadge(User $user)
    {
        /** @var \Zenomania\CoreBundle\Entity\Badge $badge */
        $badge = $this->getBadgeRepository()->findOneBy(['code' => \Zenomania\CoreBundle\Entity\Badge::TYPE_PROFILE_COMPLETED]);

        return $this->getUserBadgeRepository()->findOneBy(
            [
                'badgeId' => $badge,
                'user' => $user
            ]
        );
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