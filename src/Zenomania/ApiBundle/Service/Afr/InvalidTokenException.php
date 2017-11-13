<?php
/**
 * @package    Zenomania\ApiBundle\Service\Afr
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service\Afr;

class InvalidTokenException extends ApiException
{
    /**
     * @var \Zenomania\CoreBundle\Entity\ApiToken
     */
    private $token;

    public function __construct($token, $message, \Exception $previous = null, array $headers = array(), $code = 0)
    {
        parent::__construct(401, $message, $previous, $headers, $code);
        $this->token = $token;
    }

    /**
     * @return \Zenomania\CoreBundle\Entity\ApiToken
     */
    public function getToken(): \Zenomania\CoreBundle\Entity\ApiToken
    {
        return $this->token;
    }
}