<?php
/**
 * @package    Zenomania\ApiBundle\Service\Afr
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */


namespace Zenomania\ApiBundle\Service\Afr;


class ApiTokenAuthenticator
{
    protected $host;

    public function __construct(string $host)
    {
        $this->host = $host;
    }
}