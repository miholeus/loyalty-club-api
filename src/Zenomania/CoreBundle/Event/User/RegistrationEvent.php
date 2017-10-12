<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 02.10.17
 * Time: 18:10
 */

namespace Zenomania\CoreBundle\Event\User;


class RegistrationEvent extends AbstractEvent
{

    protected $name = 'registration.badge';

    /**
     * Event description
     *
     * @return string
     */
    public function getDescription()
    {
        return 'Регистрация';
    }
}