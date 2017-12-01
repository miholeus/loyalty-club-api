<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 29.11.17
 * Time: 18:03
 */

namespace Zenomania\CoreBundle\Event\User;


class RepostEvent extends AbstractEvent
{
    protected $name = 'repost.badge';

    /**
     * Event description
     *
     * @return string
     */
    public function getDescription()
    {
        return 'Сделал репост';
    }

}