<?php
/**
 * @package    Zenomania\ApiBundle\Service\Afr\Handler
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service\Afr\Handler;

use Doctrine\Common\Collections\ArrayCollection;
use Zenomania\CoreBundle\Document\ProviderEvent;
use Zenomania\CoreBundle\Repository\Document\ProviderEventRepository;
use Zenomania\CoreBundle\Repository\EventRepository;

class MatchesHandler
{
    /**
     * @var ProviderEventRepository
     */
    private $repository;
    /**
     * @var EventRepository
     */
    private $eventRepository;
    /**
     * @var \Closure
     */
    private $logger;

    public function __construct(ProviderEventRepository $repository, EventRepository $eventRepository)
    {
        $this->repository = $repository;
        $this->eventRepository = $eventRepository;
    }

    public function attachLogger(\Closure $closure)
    {
        $this->logger = $closure;
    }

    protected function log($message)
    {
        if (null === $this->logger) {
            return;
        }
        call_user_func($this->logger, $message);
    }
    /**
     * Returns new events
     *
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getNewEvents($limit = 100, $offset = 0)
    {
        return $this->getRepository()->findBy(['status' => ProviderEvent::STATUS_NEW], ["createdOn" => "ASC"], $limit, $offset);
    }

    /**
     * Handles events
     *
     * @param array $events
     */
    public function handle(array $events)
    {
        /** @var ProviderEvent $event */
        foreach ($events as $event) {
            try {
                $localEventId = $this->getEventRepository()->addIfNotExists($event);

                $this->getRepository()->updateStatus($event, ProviderEvent::STATUS_DONE, ['eventLocalId' => $localEventId]);
                $this->log(sprintf("<info>Updated event %d, local id %d</info>", $event->getEventId(), $localEventId));
            } catch (\Exception $e) {
                $this->log(sprintf("<error>Event %d: %s</error>", $event->getEventId(), $e->getMessage()));
                $this->getRepository()->updateStatus($event, ProviderEvent::STATUS_ERROR);
            }
        }
    }

    /**
     * Saves events to repository
     *
     * @param array $data
     */
    public function saveToStorage(array $data)
    {
        $collection = new ArrayCollection();
        foreach ($data as $item) {
            $event = ProviderEvent::fromArray($item);
            $collection->add($event);
        }

        $this->getRepository()->addIfNotExist($collection);
    }

    /**
     * @return ProviderEventRepository
     */
    public function getRepository(): ProviderEventRepository
    {
        return $this->repository;
    }

    /**
     * @return EventRepository
     */
    public function getEventRepository(): EventRepository
    {
        return $this->eventRepository;
    }
}