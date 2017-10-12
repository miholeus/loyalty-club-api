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
use Zenomania\CoreBundle\Repository\PersonRepository;
use Zenomania\CoreBundle\Service\UserBadge;

class BadgeListener
{
    /**
     * @var UserBadge
     */
    private $userBadge;

    /**
     * @var PersonRepository
     */
    private $personRepository;

    public function __construct(UserBadge $userBadge, PersonRepository $personRepository)
    {
        $this->userBadge = $userBadge;
        $this->personRepository = $personRepository;
    }

    public function onRegistrationEvent(RegistrationEvent $registrationEvent)
    {
        $this->getUserBadge()->givePointsForRegistrations($registrationEvent->getArgument('user'));
    }

    public function onUserProfileEvent(ProfileEvent $profileEvent)
    {
        $user = $profileEvent->getArgument('user');

        //Проверям заполнена ли анкета
        $person = $this->getPersonRepository()->isFullProfile($user);

        if ($person) {
            $this->getUserBadge()->giveBadgeForFullProfile($user);
        } else {
            $this->getUserBadge()->deleteBadgeForFullProfile($user);
        }
    }

    /**
     * @return UserBadge
     */
    public function getUserBadge(): UserBadge
    {
        return $this->userBadge;
    }

    /**
     * @return PersonRepository
     */
    public function getPersonRepository(): PersonRepository
    {
        return $this->personRepository;
    }
}