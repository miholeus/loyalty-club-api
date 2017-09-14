<?php
/**
 * @package    Zenomania\CoreBundle\Event\User
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\CoreBundle\Event\User;

class ReferralCodeAppliedEvent extends AbstractEvent
{
    protected $name = 'registration.referral';

    public function getDescription()
    {
        return 'Регистрация по рефкоду';
    }
}