<?php
/**
 * @package    Zenomania\CoreBundle\Event\Consumer
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */

namespace Zenomania\CoreBundle\Event\Consumer;

use PhpAmqpLib\Message\AMQPMessage;
use Zenomania\CoreBundle\Event\Processor\ProcessorInterface;

/**
 * Creates events and notifies notification consumer
 */
class PhotoUploadConsumer
{
    /**
     * @var ProcessorInterface
     */
    private $processor;

    public function __construct(ProcessorInterface $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Creates new event with destination users for future notifications
     * Publishes to "notification.new" queue
     * @see NotificationConsumer
     *
     * @param AMQPMessage $message
     * @return bool
     */
    public function execute(AMQPMessage $message)
    {
        $body = $message->getBody();

        $this->getProcessor()->process($body);

        return $message->delivery_info['consumer_tag'];
    }

    /**
     * @return ProcessorInterface
     */
    public function getProcessor()
    {
        return $this->processor;
    }
}
