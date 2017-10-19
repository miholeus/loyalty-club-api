<?php
/**
 * @package    Zenomania\CoreBundle\Event\Ticket
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\CoreBundle\Event\Ticket;

class RegistrationEvent extends AbstractEvent
{
    protected $name = 'registration';

    /**
     * Event description
     *
     * @return string
     */
    public function getDescription()
    {
        return 'Регистрация билета';
    }
}