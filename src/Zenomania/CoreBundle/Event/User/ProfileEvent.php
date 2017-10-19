<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 03.10.17
 * Time: 10:04
 */

namespace Zenomania\CoreBundle\Event\User;


class ProfileEvent extends AbstractEvent
{
    protected $name = 'profile.badge';

    /**
     * Event description
     *
     * @return string
     */
    public function getDescription()
    {
        return 'Заполнение анкеты на 100%';
    }

}