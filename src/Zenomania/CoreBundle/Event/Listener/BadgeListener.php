<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 02.10.17
 * Time: 17:36
 */

namespace Zenomania\CoreBundle\Event\Listener;

use Zenomania\CoreBundle\Entity\Person;
use Zenomania\CoreBundle\Entity\PersonPoints;
use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Event\User\ForecastEvent;
use Zenomania\CoreBundle\Event\User\RegistrationEvent;
use Zenomania\CoreBundle\Event\User\ProfileEvent;
use Zenomania\CoreBundle\Event\User\RepostEvent;
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

    /**
     * User registration event
     *
     * @param RegistrationEvent $registrationEvent
     */
    public function onRegistrationEvent(RegistrationEvent $registrationEvent)
    {
        $this->getUserBadge()->giveBadgeForRegistrations($registrationEvent->getArgument('user'));
    }

    /**
     * User
     *
     * @param ProfileEvent $profileEvent
     */
    public function onUserProfileEvent(ProfileEvent $profileEvent)
    {
        /** @var User $user */
        $user = $profileEvent->getArgument('user');

        //Проверям заполнена ли анкета
        $person = $user->getPerson();
        $profileCompleted = false;
        if (null !== $person && $this->isFullProfile($person)) {
            $profileCompleted = true;
        }

        if ($profileCompleted) {
            $this->getUserBadge()->giveBadgeIfProfileCompleted($user);
        } else {
            $this->getUserBadge()->revokeBadgeIfProfileNotCompleted($user);
        }
    }

    /**
     * Checks if profile is completed
     *
     * @param Person $person
     * @return bool
     */
    protected function isFullProfile(Person $person)
    {
        $profileCompleted = true;
        if (!$person->getFirstName() || !$person->getLastName() || !$person->getMiddleName()) {
            $profileCompleted = false;
        }
        if (!$person->getEmail() || !$person->getBdate()) {
            $profileCompleted = false;
        }
        if (!$person->getDistrict() || !$person->getCity()) {
            $profileCompleted = false;
        }
        return $profileCompleted;
    }

    public function onForecastEvent(ForecastEvent $event)
    {
        $this->getUserBadge()->giveBadgeForForecast($event->getArgument('user'));
    }

    /**
     * @param RepostEvent $event
     */
    public function onRepostEvent(RepostEvent $event)
    {
        /** @var PersonPoints $personPoints */
        $personPoints = $event->getArgument('personPoints');

        $this->getUserBadge()->giveBadgeForRepost($personPoints);
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