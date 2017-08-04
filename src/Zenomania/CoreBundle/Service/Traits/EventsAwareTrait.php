<?php
/**
 * @package    Zenomania\CoreBundle\Service\Traits
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */

namespace Zenomania\CoreBundle\Service\Traits;

use Zenomania\CoreBundle\Event\Event;
use Zenomania\CoreBundle\Event\NotificationInterface;

/**
 * Awareness of events
 */
trait EventsAwareTrait
{
    /**
     * @var NotificationInterface
     */
    protected $notificationManager;

    /**
     * Pending events
     *
     * @var Event[]
     */
    protected $pendingEvents = [];

    /**
     * @return NotificationInterface
     */
    public function getNotificationManager()
    {
        return $this->notificationManager;
    }

    /**
     * Notify events
     */
    protected function updateEvents()
    {
        $events = $this->pendingEvents;
        foreach ($events as $event) {
            $this->getNotificationManager()->notify($event);
        }
        $this->pendingEvents = [];
    }

    public function attachEvent(Event $event)
    {
        $this->pendingEvents[] = $event;
    }
}
