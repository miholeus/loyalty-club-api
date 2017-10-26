<?php
/**
 * @package    Zenomania\CoreBundle\Event\User
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\CoreBundle\Event\Ticket;

use Zenomania\CoreBundle\Event\EventInChain;

/**
 * Abstract ticket event
 * Prefixed with its own namespace
 */
abstract class AbstractEvent extends EventInChain
{
    public function getPrefix()
    {
        return 'ticket';
    }
}