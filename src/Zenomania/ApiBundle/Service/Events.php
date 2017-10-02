<?php
/**
 * @package    Zenomania\ApiBundle\Service
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service;

use Zenomania\ApiBundle\Service\Exception\EntityNotFoundException;
use Zenomania\CoreBundle\Entity\Event;
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
     * Saves Event
     *
     * @param \Zenomania\CoreBundle\Entity\Event $event
     */
    public function save(\Zenomania\CoreBundle\Entity\Event $event)
    {

        if ($event->getLineUp()->count() > 0) {
            $event->setIsLineUp(true);
        } else {
            $event->setIsLineUp(false);
        }

        $this->cleanLineUpJunk($event);
        $this->getEventRepository()->save($event);
    }

    /**
     * Удаление стартового состава, который более не привязан к матчу
     *
     * @param \Zenomania\CoreBundle\Entity\Event $event
     */
    private function cleanLineUpJunk(\Zenomania\CoreBundle\Entity\Event $event)
    {
        $originalCollection = $this->getEventRepository()->findLineUp($event);
        $currentCollection = $event->getLineUp();
        $currentIdList = [];

        foreach ($currentCollection as $item) {
            $currentIdList[] = $item->getId();
        }

        foreach ($originalCollection as $item) {
            if (!in_array($item->getId(), $currentIdList)) {
                $this->getEventRepository()->removeLineUp($item);
            }
        }
    }
    /**
     * @return EventRepository
     */
    public function getEventRepository(): EventRepository
    {
        return $this->eventRepository;
    }

    /**
     * @param Event $event
     */
    public function calculate(Event $event)
    {

    }
}