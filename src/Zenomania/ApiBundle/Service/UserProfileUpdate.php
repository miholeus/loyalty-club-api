<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 15.09.17
 * Time: 12:38
 */

namespace Zenomania\ApiBundle\Service;


use Zenomania\ApiBundle\Form\Model\UserProfile;
use Zenomania\CoreBundle\Entity\Person;
use Zenomania\CoreBundle\Repository\PersonRepository;
use Zenomania\CoreBundle\Service\User as UserService;
use Zenomania\CoreBundle\Entity\User as UserEntity;

class UserProfileUpdate
{
    /**
     * @var UserEntity
     */
    protected $userEntity;

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var PersonRepository
     */
    protected $personRepository;


    public function __construct(UserEntity $userEntity, UserService $userService, PersonRepository $personRepository)
    {
        $this->userEntity = $userEntity;
        $this->userService = $userService;
        $this->personRepository = $personRepository;
    }

    public function save(UserProfile $userProfile, UserEntity $user)
    {
        $userEntity = $user;
        $userEntity->setFirstname($userProfile->getFirstName());
        $userEntity->setLastname($userProfile->getLastName());
        $userEntity->setMiddlename($userProfile->getMiddleName());
        $userEntity->setPhone($userProfile->getPhone());
        $userEntity->setBirthDate(new \DateTime($userProfile->getBirthDate()));
        $userEntity->setEmail($userProfile->getEmail());

        $this->userService->prepareUserToSave($userEntity);
        $this->userService->save($userEntity);

        $person = $this->personRepository->findPersonByUser($userEntity);
        $person->setCity($userProfile->getCity());
        $person->setDistrict($userProfile->getDistrict());
        $this->personRepository->save($person, $person->getCity(), $person->getDistrict());
    }
}