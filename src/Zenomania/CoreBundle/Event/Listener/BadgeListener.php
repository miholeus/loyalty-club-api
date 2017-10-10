<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 02.10.17
 * Time: 17:36
 */

namespace Zenomania\CoreBundle\Event\Listener;

use Zenomania\CoreBundle\Event\User\RegistrationEvent;
use Zenomania\CoreBundle\Event\User\ProfileEvent;
use Zenomania\CoreBundle\Service\UserBadge;

class BadgeListener
{
    /**
     * @var UserBadge
     */
    private $userBadge;

    public function __construct(UserBadge $userBadge)
    {
        $this->userBadge = $userBadge;
    }

    public function onRegistrationEvent(RegistrationEvent $registrationEvent)
    {
        $this->getUserBadge()->givePointsForRegistrations($registrationEvent->getArgument('user'));
    }

    public function onUserProfileEvent(ProfileEvent $profileEvent)
    {

    }

    /**
     * @return UserBadge
     */
    public function getUserBadge(): UserBadge
    {
        return $this->userBadge;
    }

}