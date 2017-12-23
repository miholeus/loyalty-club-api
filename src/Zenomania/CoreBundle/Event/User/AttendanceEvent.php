<?php
/**
 * @package    Zenomania\CoreBundle\Event\Ticket
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\CoreBundle\Event\User;

class AttendanceEvent extends AbstractEvent
{
    protected $name = 'attendance.badge';

    /**
     * Event description
     *
     * @return string
     */
    public function getDescription()
    {
        return 'посетил матч';
    }
}