<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 16.11.17
 * Time: 15:05
 */

namespace Zenomania\CoreBundle\Event\Order;


class OrderWasCancelledEvent extends AbstractEvent
{

    protected $name = 'status.cancelled';

    /**
     * Event description
     *
     * @return string
     */
    public function getDescription()
    {
        return 'Отмена заказа';
    }
}