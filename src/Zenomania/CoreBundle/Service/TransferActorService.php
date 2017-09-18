<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 18.09.2017
 * Time: 16:39
 */

namespace Zenomania\CoreBundle\Service;


use Doctrine\ORM\EntityManager;
use Zenomania\CoreBundle\Entity\Actor;
use Zenomania\CoreBundle\Entity\DeviceToken;
use Zenomania\CoreBundle\Entity\Person;
use Zenomania\CoreBundle\Entity\SocialAccount;
use Zenomania\CoreBundle\Entity\User;

class TransferActorService
{
    private $userStatus;

    private $userRole;

    private $em;

    private $userRepository;

    private $socialAccRepository;

    private $deviceTokenRepository;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->userRepository = $em->getRepository('ZenomaniaCoreBundle:User');
        $this->socialAccRepository = $em->getRepository('ZenomaniaCoreBundle:SocialAccount');
        $this->deviceTokenRepository = $em->getRepository('ZenomaniaCoreBundle:DeviceToken');
    }

    public function transfer(Actor $actor, Person $person)
    {
        $params = [
            'status' => $this->getUserStatus(),
            'role' => $this->getUserRole(),
            'firstname' => $person->getFirstName(),
            'lastname' => $person->getLastName(),
            'middlename' => $person->getMiddleName(),
            'login' => $actor->getUsername(),
            'email' => $person->getEmail(),
            'password' => $actor->getPassword(),
            'birthDate' => $person->getBdate(),
            'avatar' => $person->getAvatar(),
            'phone' => $person->getMobile(),
            'mailNotification' => $person->getEmailAllowed(),
            'mustChangePasswd' => true,
            'isActive' => true,
            'isBlocked' => false,
            'isDeleted' => false,
            'isSuperuser' => false
        ];

        $user = User::fromArray($params);
        $this->getUserRepository()->save($user);

        $person->setUser($user);
        $this->getEm()->persist($person);
        $this->getEm()->flush();

        if (!empty($actor->getVkId())) {
            if (empty($this->getSocialAccRepository()->findOneBy(['network' => 'vk', 'outerId' => $actor->getVkId()]))) {
                $params = [
                    'person' => $person,
                    'network' => 'vk',
                    'clubId' => $actor->getClubOwner()->getId(),
                    'outerId' => $actor->getVkId(),
                    'deleted' => false
                ];

                $socialAcc = SocialAccount::fromArray($params);
                $this->getSocialAccRepository()->save($socialAcc);
            }
        }

        if (!empty($actor->getFbId())) {
            if (empty($this->getSocialAccRepository()->findOneBy(['network' => 'facebook', 'outerId' => $actor->getFbId()]))) {
                $params = [
                    'person' => $person,
                    'network' => 'facebook',
                    'clubId' => $actor->getClubOwner()->getId(),
                    'outerId' => $actor->getFbId(),
                    'deleted' => false
                ];

                $socialAcc = SocialAccount::fromArray($params);
                $this->getSocialAccRepository()->save($socialAcc);
            }
        }

        if (!empty($actor->getAuthToken())) {
            $params = [
                'user' => $user,
                'token' => $actor->getAuthToken(),
                'status' => 1
            ];

            $deviceToken = DeviceToken::fromArray($params);
            $this->getEm()->persist($deviceToken);
            $this->getEm()->flush();
        }
    }

    /**
     * @return mixed
     */
    public function getUserStatus()
    {
        return $this->userStatus;
    }

    /**
     * @param mixed $userStatus
     */
    public function setUserStatus($userStatus)
    {
        $this->userStatus = $userStatus;
    }

    /**
     * @return mixed
     */
    public function getUserRole()
    {
        return $this->userRole;
    }

    /**
     * @param mixed $userRole
     */
    public function setUserRole($userRole)
    {
        $this->userRole = $userRole;
    }

    /**
     * @return \Doctrine\ORM\EntityRepository|\Zenomania\CoreBundle\Repository\UserRepository
     */
    public function getUserRepository()
    {
        return $this->userRepository;
    }

    /**
     * @return EntityManager
     */
    public function getEm(): EntityManager
    {
        return $this->em;
    }

    /**
     * @return \Doctrine\ORM\EntityRepository|\Zenomania\CoreBundle\Repository\SocialAccountRepository
     */
    public function getSocialAccRepository()
    {
        return $this->socialAccRepository;
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getDeviceTokenRepository(): \Doctrine\ORM\EntityRepository
    {
        return $this->deviceTokenRepository;
    }
}