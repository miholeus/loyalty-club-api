<?php
/**
 * @package    Zenomania\ApiBundle\Service\Afr
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */


namespace Zenomania\ApiBundle\Service\Afr;


class ApiTokenAuthenticator
{
    /**
     * @var TokenService
     */
    private $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }
    public function authenticate(string $token)
    {

    }

    /**
     * @return TokenService
     */
    public function getTokenService(): TokenService
    {
        return $this->tokenService;
    }
}