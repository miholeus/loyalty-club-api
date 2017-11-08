<?php
/**
 * @package    Zenomania\ApiBundle\Service\Afr
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service\Afr;

use Zenomania\ApiBundle\Service\Afr\Filter\EventFilter;
use Zenomania\CoreBundle\Entity\ApiToken;

class IntegrationService
{
    /**
     * Authentication token for remote service
     *
     * @var \Zenomania\ApiBundle\Service\Afr\ApiToken
     */
    private $token;
    /**
     * Api client for remote service
     *
     * @var ApiClient
     */
    private $client;

    public function __construct(\Zenomania\ApiBundle\Service\Afr\ApiToken $token, ApiClient $client)
    {
        $this->token = $token;
        $this->client = $client;
    }
    public function getToken(): TokenInterface
    {
        return $this->token;
    }
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
        $filter = new EventFilter(['clubId' => $clubId, 'page' => $page]);
        $data = $this->getClient()->getEvents($token, $filter);
        return $data;
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

    /**
     * @return ApiClient
     */
    public function getClient(): ApiClient
    {
        return $this->client;
    }
}