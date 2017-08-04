<?php
/**
 * @package    Zenomania\CoreBundle\Event
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */

namespace Zenomania\CoreBundle\Event;
/**
 * Interface NotificationInterface
 * Main interface for notification system
 */
interface NotificationInterface
{
    /**
     * Notify about triggered event
     *
     * @param $event
     * @return mixed
     */
    public function notify(Event $event);
}