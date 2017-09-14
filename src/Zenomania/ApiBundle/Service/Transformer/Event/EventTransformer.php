<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 14.09.2017
 * Time: 17:30
 */

namespace Zenomania\ApiBundle\Service\Transformer\Event;

use Zenomania\CoreBundle\Entity\Event;
use Zenomania\CoreBundle\Service\Utils\HostBasedUrl;
use Zenomania\ApiBundle\Service\Transformer\TransformerAbstract;


class EventTransformer extends TransformerAbstract
{
    /**
     * @var HostBasedUrl
     */
    private $url;

    public function __construct(HostBasedUrl $url)
    {
        $this->url = $url;
    }

    public function transform(Event $event)
    {
        return [
            'club_home' => $event->getClubHome()->getName(),
            'club_guest' => $event->getClubGuest()->getName(),
            'place' => $event->getPlace()->getName(),
            'name' => $event->getName(),
            'date' => $event->getDate()->format('d-m-Y H:i'),
            'score_home' => $event->getScoreHome(),
            'score_guest' => $event->getScoreGuest(),
            'score_in_round' => $event->getScoreInRounds(),
            'mvp' => $event->getMvp()->getLastname()
        ];
    }
}