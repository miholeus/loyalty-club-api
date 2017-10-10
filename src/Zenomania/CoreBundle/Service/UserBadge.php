<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 09.10.17
 * Time: 15:46
 */

namespace Zenomania\CoreBundle\Service;

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

    public function givePointsForRegistrations(User $user)
    {
        $userBadge = new UserBadgeEntity();

        /** @var \Zenomania\CoreBundle\Entity\Badge $badge */
        $badge = $this->getBadgeRepository()->findOneBy(['code' => 'hello']);

        $userBadge->setUser($user);
        $userBadge->setPoints($badge->getPoints());
        $userBadge->setBadgeId($badge);
        $userBadge->setCreatedOn(new \DateTime());

        $this->getUserBadgeRepository()->save($userBadge);
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