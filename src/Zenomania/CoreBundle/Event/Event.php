<?php
/**
 * @package    Zenomania\CoreBundle\Event
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */

namespace Zenomania\CoreBundle\Event;
/**
 * Event class
 * Main component for event management system
 * It can hold any information about domain
 */
class Event extends \Symfony\Component\EventDispatcher\GenericEvent implements EventInterface
{
    /**
     * Event's name
     *
     * @var string
     */
    protected $name;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
