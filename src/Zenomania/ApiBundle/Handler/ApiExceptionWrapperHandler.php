<?php
/**
 * @package    Zenomania\ApiBundle\Handler
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */

namespace Zenomania\ApiBundle\Handler;

class ApiExceptionWrapperHandler
{

    public function wrap($data)
    {
        /** @var \Symfony\Component\Debug\Exception\FlattenException $exception */
        $exception = $data['exception'];
        $errors = null;
        if (in_array(
                $exception->getClass(), [
                'Zenomania\ApiBundle\Service\Exception\FormValidateException',
                'Zenomania\ApiBundle\Service\Exception\ParameterValidateException'
            ])) {
            $errors = $exception->getHeaders();
            $exception->setHeaders([]);
        }
        $newException = array(
            'success' => false,
            'exception' => array(
                'code' => $exception->getStatusCode(),
                'message' => $exception->getStatusCode() !== 500 ? $exception->getMessage() : $data['status_text']
            ),
            'errors' => $errors
        );

        return $newException;
    }
}
