<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 15.09.17
 * Time: 12:38
 */

namespace Zenomania\ApiBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Zenomania\ApiBundle\Form\Model\UserProfile as ProfileModel;
use Zenomania\CoreBundle\Entity\Person;
use Zenomania\CoreBundle\Event\User\ProfileEvent;
use Zenomania\CoreBundle\Repository\PersonRepository;
use Zenomania\CoreBundle\Service\User as UserService;
use Zenomania\CoreBundle\Service\Traits\EventsAwareTrait;


class UserProfile
{
    use EventsAwareTrait;

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var PersonRepository
     */
    protected $personRepository;

    /**
     * @var NotificationInterface
     */
    protected $notificationManager;

    /**
     * @return UserService
     */
    public function getUserService(): UserService
    {
        return $this->userService;
    }

    /**
     * @return PersonRepository
     */
    public function getPersonRepository(): PersonRepository
    {
        return $this->personRepository;
    }

    public function __construct(
        UserService $userService,
        PersonRepository $personRepository,
        ContainerInterface $container
    ) {
        $this->userService = $userService;
        $this->personRepository = $personRepository;
        $this->notificationManager = $container->get('event.notification_manager');
    }

    /**
     * Saves user profile
     *
     * @param ProfileModel $profile
     */
    public function save(ProfileModel $profile)
    {
        $user = $profile->getUser();

        $this->getUserService()->save($user);

        $person = $this->getPersonRepository()->findPersonByUser($user);

        $profileData = [
            'firstName' => $profile->getFirstName(),
            'lastName' => $profile->getLastName(),
            'middleName' => $profile->getMiddleName(),
            'email' => $profile->getEmail(),
            'mobile' => $user->getPhone(),
            'bdate' => $user->getBirthDate(),
            'user' => $user
        ];

        if (null === $person) {
            $person = Person::fromArray($profileData);
        } else {
            $person->setFromArray($profileData);
        }
        if (null !== $profile->getCity() && null !== $profile->getCity()->getId()) {
            $person->setCity($profile->getCity());
        }
        if (null !== $profile->getDistrict() && null !== $profile->getDistrict()->getId()) {
            $person->setDistrict($profile->getDistrict());
        }

        $this->getPersonRepository()->save($person);

        $event = new ProfileEvent();
        $event->setArgument('user', $user);
        $this->attachEvent($event);
        $this->updateEvents();
    }
}