<?php
/**
 * @package    Zenomania\ApiBundle\Controller
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Controller;

use Monolog\Logger;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Handles exceptions
 */
class ExceptionController extends RestController
{
    public function showAction(Request $request, $exception, Logger $logger = null)
    {
        if (!$exception instanceof HttpException) {
            $exception = new HttpException(500, $exception->getMessage(), $exception);
        }
        if ($exception->getStatusCode() == 500 && null !== $logger) {
            $logger->crit($exception->getMessage(), ['trace' => $exception->getTraceAsString()]);
        }

        $wrapper = $this->get('api.exception_handler');
        $data = [
            'exception' => $exception,
            'status_text' => 'Internal Server Error'
        ];
        $wrapped = $wrapper->wrap($data);
        $view = $this->view($wrapped, $wrapped['exception']['code']);
        return $this->handleView($view);
    }
}