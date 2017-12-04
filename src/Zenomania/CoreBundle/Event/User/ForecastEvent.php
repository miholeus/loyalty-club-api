<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 27.11.17
 * Time: 13:30
 */

namespace Zenomania\CoreBundle\Event\User;


class ForecastEvent extends AbstractEvent
{
    protected $name = 'forecast.badge';

    /**
     * Event description
     *
     * @return string
     */
    public function getDescription()
    {
        return 'Угадал общий счёт матча';
    }

}