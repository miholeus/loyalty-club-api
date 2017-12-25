<?php
/**
 * @package    Zenomania\ApiBundle\Service\Afr
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service\Afr;

class Endpoint
{
    /**
     * Authentication url
     */
    const AUTH_URL = '/api/v1/auth/login';
    /**
     * Matches for selected club
     */
    const MATCHES_URL = '/api/v1/clubs/:club/events';
    /**
     * Tickets for selected event
     */
    const TICKETS_URL = '/api/v1/events/:id/tickets';
    /**
     * Subscriptions for selected club
     */
    const SUB_URL = '/api/v1/clubs/:club/subs';
    /**
     * Clubs for selected sport
     */
    const CLUBS_URL = '/api/v1/sports/:sport/clubs';
}