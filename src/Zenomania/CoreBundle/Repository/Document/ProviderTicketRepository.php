<?php

namespace Zenomania\CoreBundle\Repository\Document;

use Doctrine\ODM\MongoDB\DocumentRepository;
use Zenomania\CoreBundle\Document\ProviderTicket;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * ProviderTicketRepository
 *
 * This class was generated by the Doctrine ODM. Add your own custom
 * repository methods below.
 */
class ProviderTicketRepository extends DocumentRepository
{
    public function addIfNotExist(ArrayCollection $collection)
    {
        /** @var ProviderTicket $ticket */
        foreach ($collection as $ticket) {
            if (!$this->exists($ticket->getTicketId())) {
                $this->dm->persist($ticket);
            }
        }
        $this->dm->flush();
    }

    /**
     * @param ProviderTicket $ticket
     * @param $status
     */
    public function updateStatus(ProviderTicket $ticket, $status)
    {
        $ticket->setStatus($status);
        $ticket->setUpdatedOn(new \DateTime());
        $this->dm->persist($ticket);
        $this->dm->flush();
    }
    /**
     * Checks if event id already exists
     *
     * @param int $ticketId
     * @return bool
     */
    protected function exists(int $ticketId): bool
    {
        $result = $this->getDocumentManager()->createQueryBuilder('ZenomaniaCoreBundle:ProviderTicket')
            ->field('ticket_id')->equals($ticketId)->count()->getQuery()->execute();

        return $result !== 0;
    }
}
