<?php
/**
 * @package    Zenomania\CoreBundle\DataFixtures\ORM
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Entity\UserRole;
use Zenomania\CoreBundle\Entity\UserStatus;

class LoadBotUserData extends AbstractFixture
    implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @return UserStatus
     */
    protected function getStatus(): UserStatus
    {
        return $this->container->get('repository.user_repository')->getStatus(UserStatus::STATUS_REGISTERED);
    }

    /**
     * @return UserRole
     */
    protected function getRole(): UserRole
    {
        return $this->container->get('repository.user_repository')->getRole(UserRole::ROLE_USER);
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setStatus();
        $user->setRole();
        $user->setFirstname('Bot');
        $user->setLastname('Bot');
        $user->setLogin('bot_user');
        $user->setEmail('bot@selloutsport.com');
        $user->setPhone('71234567890');
        $user->setRole($this->getRole());
        $user->setStatus($this->getStatus());
        $password = rand(1000000, 10000000);

        $user->setPassword($password);
        $user->setBirthDate(new \DateTime("now"));
        $user->setMailNotification(false);
        $user->setMustChangePasswd(false);
        $user->setIsActive(false);
        $user->setIsSuperuser(false);

        $manager->persist($user);
        $manager->flush();
    }

    public function getOrder()
    {
        return 6;
    }
}