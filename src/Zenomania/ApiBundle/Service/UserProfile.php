<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 15.09.17
 * Time: 12:38
 */

namespace Zenomania\ApiBundle\Service;


use Zenomania\ApiBundle\Form\Model\UserProfile as UserModel;
use Zenomania\CoreBundle\Repository\PersonRepository;
use Zenomania\CoreBundle\Service\User as UserService;
use Zenomania\CoreBundle\Entity\User as UserEntity;

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

    public function save(UserModel $userModel, UserEntity $userEntity)
    {
        $userEntity->setFirstname($userModel->getFirstName());
        $userEntity->setLastname($userModel->getLastName());
        $userEntity->setMiddlename($userModel->getMiddleName());
        $userEntity->setPhone($userModel->getPhone());
        $userEntity->setBirthDate(new \DateTime($userModel->getBirthDate()));
        $userEntity->setEmail($userModel->getEmail());

        $this->getUserService()->prepareUserToSave($userEntity);
        $this->getUserService()->save($userEntity);

        $person = $this->getPersonRepository()->findPersonByUser($userEntity);
        $person->setCity($userModel->getCity());
        $person->setDistrict($userModel->getDistrict());
        $this->getPersonRepository()->save($person, $person->getCity(), $person->getDistrict());
    }
}