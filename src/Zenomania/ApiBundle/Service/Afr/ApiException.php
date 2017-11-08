<?php
/**
 * @package    Zenomania\ApiBundle\Service\Afr
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service\Afr;

use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiException extends HttpException
{
    /**
     * @param $code
     * @param $message
     * @return ApiException
     */
    public static function createException($code, $message)
    {
        return new self($code, $message);
    }
}