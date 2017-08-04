<?php
/**
 * @package    Zenomania\CoreBundle\Event
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */

namespace Zenomania\CoreBundle\Event;
/**
 * Interface for events
 * Each event should have name
 */
interface EventInterface
{
    /**
     * @return string
     */
    public function getName();
}