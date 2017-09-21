<?php
/**
 * @package    Zenomania\ApiBundle\Service
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service;

use Zenomania\ApiBundle\Service\Exception\EntityNotFoundException;
use Zenomania\CoreBundle\Repository\EventRepository;

class Events
{
    /**
     * @var EventRepository
     */
    private $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    /**
     * Finds next event
     *
     * @return null|\Zenomania\CoreBundle\Event\Event
     * @throws EntityNotFoundException
     */
    public function nextEvent()
    {
        $dt = new \DateTimeImmutable();
        $event = $this->getEventRepository()->findNextEvent($dt);

        if (null === $event) {
            throw EntityNotFoundException::eventNotFound();
        }
        return $event;
    }

    /**
     * @return EventRepository
     */
    public function getEventRepository(): EventRepository
    {
        return $this->eventRepository;
    }
}