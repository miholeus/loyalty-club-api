<?php
/**
 * @package    Zenomania\ApiBundle\Service\Transformer\Event
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */


namespace Zenomania\ApiBundle\Service\Transformer\Event;


use Zenomania\ApiBundle\Service\Transformer\TransformerAbstract;
use Zenomania\CoreBundle\Entity\Event;

class EventPredictionTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['club_home', 'club_guest'];

    public function transform(Event $event)
    {
        return [
            'id' => $event->getId()
        ];
    }
}