<?php
/**
 * @package    Zenomania\CoreBundle\Event\Listener
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\CoreBundle\Event\Listener;

use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;
use Zenomania\CoreBundle\Entity\Club;
use Zenomania\CoreBundle\Event\Club\ClubReceivedEvent;
use Zenomania\CoreBundle\Event\Exception;

class ClubListener
{
    /**
     * @var ProducerInterface
     */
    private $producer;

    public function __construct(ProducerInterface $producer)
    {
        $this->producer = $producer;
    }

    public function onClubReceivedEvent(ClubReceivedEvent $event)
    {
        $club = $event->getSubject();
        if (!$club instanceof Club) {
            throw new Exception(sprintf("Club received event must take club instance as subject, but %s given", is_object($club) ? get_class($club) : gettype($club)));
        }

        $logo = $event->getArgument('logo');

        // publish event to broker
        $routeKey = sprintf('photos.clubs.%d', $club->getId());
        $event = [
            'name' => $event->getName(),
            'id' => $club->getId(),
            'logo' => $logo
        ];
        $this->getProducer()->publish(serialize($event), $routeKey);
    }

    /**
     * @return ProducerInterface
     */
    public function getProducer(): ProducerInterface
    {
        return $this->producer;
    }
}