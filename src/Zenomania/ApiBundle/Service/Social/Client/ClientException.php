<?php
/**
 * @package    Zenomania\ApiBundle\Service\Social\Client
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service\Social\Client;

use Zenomania\CoreBundle\Exception;

class ClientException extends Exception
{
    private $statusCode;

    public function __construct($statusCode, $message = null, \Exception $previous = null, $code = 0)
    {
        $this->statusCode = $statusCode;

        parent::__construct($message, $code, $previous);
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }
}