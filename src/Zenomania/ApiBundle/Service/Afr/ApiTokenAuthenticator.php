<?php
/**
 * @package    Zenomania\ApiBundle\Service\Afr
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service\Afr;

use Zenomania\CoreBundle\Entity\ApiToken;
use Zenomania\CoreBundle\Entity\User;

class ApiTokenAuthenticator
{
    /**
     * @var TokenService
     */
    private $tokenService;
    /**
     * @var ApiClient
     */
    private $apiClient;

    public function __construct(TokenService $tokenService, ApiClient $apiClient)
    {
        $this->tokenService = $tokenService;
        $this->apiClient = $apiClient;
    }

    /**
     * Gets user's valid token
     *
     * @param User $user
     * @return ApiToken|null
     */
    public function getCurrentToken(User $user)
    {
        return $this->getTokenService()->getUserToken($user);
    }
    /**
     * Authenticates user
     *
     * @param User $user
     * @param TokenInterface $tokenInterface
     * @return ApiToken
     */
    public function authenticate(User $user, TokenInterface $tokenInterface)
    {
        $tokenReturned = $this->getApiClient()->authenticate($tokenInterface->getUsername(), $tokenInterface->getCredentials());

        $token = new ApiToken($tokenReturned);
        $this->getTokenService()->addUserToken($user, $token);

        return $token;
    }

    /**
     * @return TokenService
     */
    public function getTokenService(): TokenService
    {
        return $this->tokenService;
    }

    /**
     * @return ApiClient
     */
    public function getApiClient(): ApiClient
    {
        return $this->apiClient;
    }
}