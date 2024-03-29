<?php

namespace Zenomania\ApiBundle\Tests;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\UnitOfWork;
use Symfony\Component\DependencyInjection\Container;
use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Entity\UserRole;
use Zenomania\CoreBundle\Entity\UserStatus;

class TestEntityFactory
{
    private $entityManager;
    private $userService;
    private $container;

    public function __construct(EntityManager $entityManager, \Zenomania\CoreBundle\Service\User $userService, Container $container)
    {
        $this->entityManager = $entityManager;
        $this->userService = $userService;
        $this->container = $container;
    }

    /**
     * @return User
     */
    public function createUser()
    {
        $userStatus = $this->getRepository('ZenomaniaCoreBundle:UserStatus')->findOneBy(['code' => UserStatus::STATUS_ACTIVE]);
        $userRole = $this->getRepository('ZenomaniaCoreBundle:UserRole')->findOneBy(['name' => UserRole::ROLE_USER]);
        $user = new User();
        $user->setStatus($userStatus);
        $user->setRole($userRole);
        $user->setFirstname($this->getRandomString(15));
        $user->setLastname($this->getRandomString(15));
        $user->setLogin($this->getRandomString(15));
        $user->setEmail($this->getRandomString(15) . '@' . $this->getRandomString(5) . '.ru');
        $user->setPhone($this->getRandomPhoneNumber());
        $user->setIsActive(true);
        $user->setIsBlocked(false);
        $user->setIsDeleted(false);

        $this->userService->save($user);

        return $user;
    }

    /**
     * @param $entity
     * @return void
     */
    public function refreshEntity($entity)
    {
        if ($this->entityManager->getUnitOfWork()->getEntityState($entity) !== UnitOfWork::STATE_MANAGED) {
            $entity = $this->getRepository(get_class($entity))->find($entity->getId());
        }
        $this->entityManager->refresh($entity);
    }

    /**
     * @param $entities array
     * @return void
     */
    public function refreshEntities(array $entities)
    {
        foreach ($entities as $entity) {
            $this->refreshEntity($entity);
        }
    }

    /**
     * @param $class
     * @return \Doctrine\ORM\EntityRepository
     */
    private function getRepository($class)
    {
        return $this->entityManager->getRepository($class);
    }

    private function getRandomString($length, $keyspace = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        $str = '';
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[random_int(0, $max)];
        }
        return $str;
    }

    private function getRandomPhoneNumber()
    {
        return '7' . implode(
            array_map(
                function () {
                    return rand(0, 9);
                },
                range(0, 9)
            )
        );
    }
}
