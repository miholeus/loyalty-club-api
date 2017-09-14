<?php
/**
 * @package    Zenomania\ApiBundle\Normalizer
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Normalizer;

use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ExceptionNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = array())
    {
        /** @var \Symfony\Component\Debug\Exception\FlattenException $exception */
        $exception = $object;
        $errors = null;
        if (in_array(
            get_class($exception), [
            'Zenomania\ApiBundle\Service\Exception\FormValidateException',
            'Zenomania\ApiBundle\Service\Exception\ParameterValidateException'
        ])) {
            $errors = $exception->getHeaders();
            $exception->setHeaders([]);
        }

        if (!$exception instanceof FlattenException) {
            $exception = FlattenException::create($exception, 500);
        }

        $newException = array(
            'success' => false,
            'exception' => array(
                'code' => $exception->getStatusCode(),
                'message' => $exception->getStatusCode() !== 500 ? $exception->getMessage() : "Internal Server Error"
            ),
            'errors' => $errors
        );

        return $newException;
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof \Exception;
    }
}