<?php
/**
 * @package    Zenomania\ApiBundle\Service\Exception
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;

class PointsCanNotBeGrantedException extends HttpException
{
    public function __construct($message)
    {
        parent::__construct(400, $message);
    }
}