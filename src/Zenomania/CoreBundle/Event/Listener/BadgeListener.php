<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 02.10.17
 * Time: 17:36
 */

namespace Zenomania\CoreBundle\Event\Listener;

use Zenomania\CoreBundle\Event\User\RegistrationEvent;
use Zenomania\CoreBundle\Event\User\ProfileEvent;

class BadgeListener
{
    public function onRegistrationEvent(RegistrationEvent $registrationEvent)
    {

    }

    public function onUserProfileEvent(ProfileEvent $profileEvent)
    {
        
    }
}