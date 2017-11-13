<?php
/**
 * @package    Zenomania\ApiBundle\Service\Afr
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service\Afr;

class ApiToken implements TokenInterface
{
    /**
     * User name
     *
     * @var string
     */
    protected $username;
    /**
     * Password
     *
     * @var string
     */
    protected $credentials;

    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->credentials = $password;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getCredentials(): string
    {
        return $this->credentials;
    }

}