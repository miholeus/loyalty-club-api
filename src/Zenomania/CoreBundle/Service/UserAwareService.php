<?php
/**
 * @package    Zenomania\CoreBundle\Service
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */

namespace Zenomania\CoreBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Event\NotificationInterface;
use Zenomania\CoreBundle\Service\Traits\EventsAwareTrait;

/**
 * Service that takes currently logged user
 */
class UserAwareService
{
    use EventsAwareTrait;
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var User
     */
    protected $user;
    /**
     * @var NotificationInterface
     */
    protected $notificationManager;
    /**
     * @var TokenStorage
     */
    private $tokenStorage;

    public function __construct(EntityManager $em, TokenStorage $tokenStorage, NotificationInterface $notificationManager)
    {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
        $this->notificationManager = $notificationManager;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->em;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        if (null === $this->user) {
            $this->user = $this->tokenStorage->getToken()->getUser();
        }
        return $this->user;
    }
}
