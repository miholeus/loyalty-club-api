<?php
/**
 * @package    Zenomania\CoreBundle\Event\Club
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\CoreBundle\Event\Club;

use Zenomania\CoreBundle\Event\EventInChain;

/**
 * Abstract ticket event
 * Prefixed with its own namespace
 */
abstract class AbstractEvent extends EventInChain
{
    public function getPrefix()
    {
        return 'club';
    }
}