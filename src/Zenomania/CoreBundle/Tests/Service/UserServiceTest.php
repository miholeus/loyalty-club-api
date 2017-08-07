<?php

namespace Zenomania\CoreBundle\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;
use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Entity\UserRole;

class UserServiceTest extends KernelTestCase implements ContainerAwareInterface
{
    /**
     * @var EntityManager
     */
    private $em;
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param string $login
     * @return User
     */
    protected function getDemoUser($login = 'demo')
    {
        return $this->em->getRepository('Zenomania\CoreBundle:User')->findOneBy(['login' => $login]);
    }

    protected function setUp()
    {
        self::bootKernel();
        $this->setContainer(static::$kernel->getContainer());

        $this->em = static::$kernel->getContainer()
            ->get('doctrine')->getManager();
    }

    /**
     * Create user test
     *
     * @return User
     */
    protected function createUser()
    {
        $userStatus = $this->em->getRepository('ZenomaniaCoreBundle:UserStatus')->findOneBy(['code' => 'active']);
        $userRole = $this->em->getRepository('ZenomaniaCoreBundle:UserRole')->findOneBy(['name' => UserRole::ROLE_USER]);

        $user = new User();
        $user->setStatus($userStatus);
        $user->setRole($userRole);
        $user->setFirstname('Тестовый юзер');
        $user->setLastname('Тестовый юзер');
        $user->setMiddlename('Тестовый юзер');
        $user->setLogin('test');
        $user->setEmail('testuser@test.com');
        $user->setPhone('79999999997');
        $user->setIsActive(true);
        $this->em->persist($user);

        $this->em->flush();
        $this->em->refresh($user);
        return $user;
    }

    public function testCreateUser()
    {
        $user = $this->createUser();
        $this->assertNotNull($user->getId());
    }

    public function testUserCanBeFoundByEmail()
    {
        $service = $this->container->get('user.service');
        $email = 'noreply@selloutsport.com';
        $user = $service->findByEmail($email);
        $this->assertNotNull($user);
        $this->assertEquals($email, $user->getEmail());
    }

    protected function tearDown()
    {
        $q = $this->em->createQuery("DELETE FROM Zenomania\CoreBundle\Entity\User u WHERE u.login NOT IN (:login)");
        $q->setParameter('login', ['demo', 'rose']);
        $q->execute();
        $this->em->close();
        parent::tearDown();
    }
}
