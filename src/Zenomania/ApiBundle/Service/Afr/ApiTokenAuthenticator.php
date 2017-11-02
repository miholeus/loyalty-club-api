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
        $token->makeValidFor(3600);
        $user->addToken($token);
        $this->getTokenService()->addUserToken($user);

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