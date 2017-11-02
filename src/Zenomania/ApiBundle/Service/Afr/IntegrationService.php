<?php
/**
 * @package    Zenomania\ApiBundle\Service\Afr
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service\Afr;

use Zenomania\CoreBundle\Entity\ApiToken;

class IntegrationService
{
    /**
     * Fetches matches from service and saves it to storage
     *
     * @param ApiToken $token
     * @param $clubId
     * @param int $page
     * @return array
     */
    public function fetchMatches(ApiToken $token, $clubId, $page = 1)
    {
        return [];
    }

    /**
     * Fetches tickets from services and saves it to storage
     *
     * @param ApiToken $token
     * @param $eventId
     * @param int $page
     * @return array
     */
    public function fetchTickets(ApiToken $token, $eventId, $page = 1)
    {
        return [];
    }
}