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
    public function addUserToken(User $user, \Zenomania\CoreBundle\Entity\ApiToken $token)
    {
        $token->makeValidFor(3600);
        $user->addToken($token);

        $this->getUserService()->save($user);
    }

    /**
     * @param User $user
     * @return \Zenomania\CoreBundle\Entity\ApiToken|null
     */
    public function getUserToken(User $user)
    {
        $token = $user->getValidToken();
        return $token;
    }


    /**
     * Removes user token
     *
     * @param \Zenomania\CoreBundle\Entity\User $user
     * @param string $token
     */
    public function removeToken(\Zenomania\CoreBundle\Entity\User $user, string $token)
    {
        $user->removeTokenByName($token);
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