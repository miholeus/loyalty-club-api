<?php
/**
 * @package    Zenomania\ApiBundle\Service\Afr\Handler
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service\Afr\Handler;

use Doctrine\Common\Collections\ArrayCollection;
use Zenomania\CoreBundle\Document\ProviderTicket;
use Zenomania\CoreBundle\Repository\Document\ProviderTicketRepository;

class TicketsHandler
{
    /**
     * @var ProviderTicketRepository
     */
    private $repository;

    public function __construct(ProviderTicketRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Saves tickets to repository
     *
     * @param array $data
     * @param int $eventId
     */
    public function handle(array $data, int $eventId)
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
     * @return ProviderTicketRepository
     */
    public function getRepository(): ProviderTicketRepository
    {
        return $this->repository;
    }
}