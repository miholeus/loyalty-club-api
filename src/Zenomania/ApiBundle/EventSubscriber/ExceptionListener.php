<?php
/**
 * @package    Zenomania\ApiBundle\EventSubscriber
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ExceptionListener implements EventSubscriberInterface
{
    private $serializer;
    private $normalizers;

    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
        $this->normalizers = [];
    }

    public function processException(GetResponseForExceptionEvent $event, $name, $dispatcher)
    {
        $result = null;
        $exception = $event->getException();

        if($event->getRequest()->getContentType() !== 'json' &&
            !preg_match("~\/api~", $event->getRequest()->getRequestUri())) {
            return;
        }

        /** @var NormalizerInterface $normalizer */
        foreach ($this->normalizers as $normalizer) {
            if ($normalizer->supportsNormalization($exception)) {
                $result = $normalizer->normalize($exception);
                break;
            }
        }


        if (null !== $result) {
            $result['success'] = false;

            $code = $exception instanceof HttpException ? $exception->getStatusCode() : $exception->getCode();
            $result['exception'] = [
                'code' => $code ?: Response::HTTP_BAD_REQUEST,
                'message' => $event->getException()->getMessage()
            ];

            $body = $this->serializer->serialize($result, 'json');

            $event->setResponse(new Response($body, $result['exception']['code']));
        }
    }

    public function addNormalizer(NormalizerInterface $normalizer)
    {
        $this->normalizers[] = $normalizer;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => [['processException', 255]]
        ];
    }
}