<?php
/**
 * @package    Zenomania\ApiBundle\Service\Afr
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service\Afr;

use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Service\User as UserService;

class TokenService
{
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Adds token to repository
     *
     * @param User $user
     */
    public function addUserToken(User $user)
    {
        $this->getUserService()->save($user);
    }

    /**
     * @return UserService
     */
    public function getUserService(): UserService
    {
        return $this->userService;
    }
}