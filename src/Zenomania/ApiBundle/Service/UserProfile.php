<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 15.09.17
 * Time: 12:38
 */

namespace Zenomania\ApiBundle\Service;

use Zenomania\ApiBundle\Form\Model\UserProfile as ProfileModel;
use Zenomania\CoreBundle\Entity\Person;
use Zenomania\CoreBundle\Repository\PersonRepository;
use Zenomania\CoreBundle\Service\User as UserService;

class UserProfile
{
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var PersonRepository
     */
    protected $personRepository;

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


    public function __construct(UserService $userService, PersonRepository $personRepository)
    {
        $this->userService = $userService;
        $this->personRepository = $personRepository;
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
        if (null === $person) {
            $person = Person::fromArray([
                'firstName' => $profile->getFirstName(),
                'lastName' => $profile->getLastName(),
                'middleName' => $profile->getLastName(),
                'email' => $profile->getEmail(),
                'mobile' => $user->getPhone(),
                'bdate' => $user->getBirthDate(),
                'user' => $user
            ]);
        }
        if (null !== $profile->getCity()->getId()) {
            $person->setCity($profile->getCity());
        }
        if (null !== $profile->getDistrict()->getId()) {
            $person->setDistrict($profile->getDistrict());
        }

        $this->getPersonRepository()->save($person);
    }
}