<?php
/**
 * @package    Zenomania\CoreBundle\Event\Club
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\CoreBundle\Event\Club;

class ClubReceivedEvent extends AbstractEvent
{
    protected $name = 'received';

    public function getDescription()
    {
        return 'Получение нового клуба из АФР';
    }
}