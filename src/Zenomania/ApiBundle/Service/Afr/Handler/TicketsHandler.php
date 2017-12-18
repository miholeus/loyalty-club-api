<?php
/**
 * @package    Zenomania\ApiBundle\Service\Afr\Handler
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service\Afr\Handler;

use Doctrine\Common\Collections\ArrayCollection;
use Zenomania\CoreBundle\Document\ProviderTicket;
use Zenomania\CoreBundle\Repository\Document\ProviderTicketRepository;
use Zenomania\CoreBundle\Repository\TicketRepository;

class TicketsHandler
{
    /**
     * @var ProviderTicketRepository
     */
    private $repository;
    /**
     * @var TicketRepository
     */
    private $ticketRepository;

    public function __construct(ProviderTicketRepository $repository, TicketRepository $ticketRepository)
    {
        $this->repository = $repository;
        $this->ticketRepository = $ticketRepository;
    }

    /**
     * Saves tickets to repository
     *
     * @param array $data
     * @param int $eventId
     */
    public function saveToStorage(array $data, int $eventId)
    {
        $collection = new ArrayCollection();
        foreach ($data as $item) {
            $event = ProviderTicket::fromArray($item);
            $event->setEventId($eventId);
            $collection->add($event);
        }

        $this->getRepository()->addIfNotExist($collection);
    }

    /**
     * Returns new tickets
     *
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getNewTickets($limit = 1000, $offset = 0)
    {
        return $this->getRepository()->findBy(["status" => ProviderTicket::STATUS_NEW], ["date" => "ASC"], $limit, $offset);
    }

    /**
     * Handles tickets
     *
     * @param array $tickets
     */
    public function handle(array $tickets)
    {
        $repo = $this->getTicketRepository();
        /** @var ProviderTicket $ticket */
        foreach ($tickets as $ticket) {
            try {
                $data = $ticket->toArray();
                $repo->addIfNotExists($data);
                $this->getRepository()->updateStatus($ticket, ProviderTicket::STATUS_DONE);
            } catch (\Exception $e) {
                $this->getRepository()->updateStatus($ticket, ProviderTicket::STATUS_ERROR);
            }
        }
    }

    /**
     * @return ProviderTicketRepository
     */
    public function getRepository(): ProviderTicketRepository
    {
        return $this->repository;
    }

    /**
     * @return TicketRepository
     */
    public function getTicketRepository(): TicketRepository
    {
        return $this->ticketRepository;
    }
}