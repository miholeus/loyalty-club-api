<?php
/**
 * @package    Zenomania\ApiBundle\Service\Afr\Filter
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service\Afr\Filter;

use Zenomania\ApiBundle\Request\Filter\AbstractFilter;

class TicketFilter extends AbstractFilter
{
    protected $page = 1;

    protected $eventId;

    public function getRequest()
    {
        return [
            'page' => $this->page ?? 1
        ];
    }

    public function getEventId(): int
    {
        return $this->eventId;
    }
}