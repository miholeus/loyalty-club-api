<?php
/**
 * @package    Zenomania\CoreBundle\Event
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */

namespace Zenomania\CoreBundle\Event;
/**
 * Events that are used in chain should be prefixed
 */
abstract class EventInChain extends Event implements EventInChainInterface
{
    abstract public function getPrefix();

    public function getName()
    {
        return sprintf("%s.%s", $this->getPrefix(), $this->name);
    }

    /**
     * @return string
     */
    public function getClearName()
    {
        return $this->name;
    }

    /**
     * Event description
     *
     * @return string
     */
    abstract public function getDescription();
}
