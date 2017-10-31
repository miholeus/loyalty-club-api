<?php
/**
 * @package    Zenomania\ApiBundle\Service\Afr
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service\Afr;

class Endpoint
{
    const AUTH_URL = '/api/v1/auth/login';
    const MATCHES_URL = '/api/v1/clubs/:club/events';
    const TICKETS_URL = '/api/v1/events/:id/tickets';
}