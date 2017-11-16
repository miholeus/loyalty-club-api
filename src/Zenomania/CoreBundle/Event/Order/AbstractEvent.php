<?php
/**
 * @package    Zenomania\CoreBundle\Event\User
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\CoreBundle\Event\Order;

use Zenomania\CoreBundle\Event\EventInChain;

/**
 * Abstract user event
 * Prefixed with its own namespace
 */
abstract class AbstractEvent extends EventInChain
{
    public function getPrefix()
    {
        return 'order';
    }
}