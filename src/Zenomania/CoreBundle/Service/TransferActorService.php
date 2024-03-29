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

    /** @var EntityManager */
    private $em;

    /** @var \Zenomania\CoreBundle\Repository\UserRepository */
    private $userRepository;

    /** @var \Zenomania\CoreBundle\Repository\SocialAccountRepository */
    private $socialAccRepository;

    /** @var \Doctrine\ORM\EntityRepository */
    private $deviceTokenRepository;

    /** @var \Zenomania\CoreBundle\Repository\PersonRepository  */
    private $personRepository;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->userRepository = $em->getRepository('ZenomaniaCoreBundle:User');
        $this->socialAccRepository = $em->getRepository('ZenomaniaCoreBundle:SocialAccount');
        $this->deviceTokenRepository = $em->getRepository('ZenomaniaCoreBundle:DeviceToken');
        $this->personRepository = $em->getRepository('ZenomaniaCoreBundle:Person');
    }

    public function transfer(Actor $actor, Person $person)
    {
        $email = $person->getEmail();
        if (empty($email)) {
            $email = null;
        }
        if (false === filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email = null;
            // update person email
            $this->personRepository->cleanEmail($person->getId());
        }

        $params = [
            'status' => $this->getUserStatus() ?? null,
            'role' => $this->getUserRole() ?? null,
            'firstname' => $person->getFirstName() ?? null,
            'lastname' => $person->getLastName() ?? null,
            'middlename' => $person->getMiddleName() ?? null,
            'login' => $actor->getUsername() ?? null,
            'email' => $email,
            'password' => $actor->getPassword() ?? null,
            'birthDate' => $person->getBdate() ?? null,
            'avatar' => $person->getAvatar() ?? null,
            'phone' => (null !== $person->getMobile()) ? preg_replace('/\D/', '', $person->getMobile()) : null,
            'mailNotification' => $person->getEmailAllowed() ?? null,
            'mustChangePasswd' => true,
            'isActive' => true,
            'isBlocked' => false,
            'isDeleted' => false,
            'isSuperuser' => false
        ];
        if (!empty($actor->getRegDate())) {
            $params['createdOn'] = $actor->getRegDate();
        }
        foreach (['firstname', 'lastname'] as $name) {
            if (mb_strlen($params[$name], 'utf-8') < 3) {
                $params[$name] = $params[$name] . time();
            }
        }

        $user = User::fromArray($params);
        $this->getEm()->persist($user);

        $person->setUser($user);
        $this->getEm()->persist($person);

        $socialAccounts = ['facebook' => $actor->getFbId(), 'vk' => $actor->getVkId()];
        foreach ($socialAccounts as $network => $networkId) {
            if (empty($networkId)) continue;
            if ($this->getSocialAccRepository()->isNewSocialAccount($network, $networkId)) {
                $params = [
                    'person' => $person,
                    'network' => $network,
                    'clubId' => $actor->getClubOwner()->getId(),
                    'outerId' => $networkId,
                    'deleted' => false
                ];

                $socialAcc = SocialAccount::fromArray($params);
                $this->getEm()->persist($socialAcc);
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
        }

        $this->getEm()->flush();
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
     * @return \Zenomania\CoreBundle\Repository\UserRepository
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
     * @return \Zenomania\CoreBundle\Repository\SocialAccountRepository
     */
    public function getSocialAccRepository()
    {
        return $this->socialAccRepository;
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getDeviceTokenRepository()
    {
        return $this->deviceTokenRepository;
    }

    /**
     * @return \Zenomania\CoreBundle\Repository\PersonRepository
     */
    public function getPersonRepository()
    {
        return $this->personRepository;
    }
}
