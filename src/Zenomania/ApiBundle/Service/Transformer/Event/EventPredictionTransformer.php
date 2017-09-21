<?php
/**
 * @package    Zenomania\ApiBundle\Service\Transformer\Event
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */


namespace Zenomania\ApiBundle\Service\Transformer\Event;


use Zenomania\ApiBundle\Service\Transformer\ClubTransformer;
use Zenomania\ApiBundle\Service\Transformer\PlayerTransformer;
use Zenomania\ApiBundle\Service\Transformer\TransformerAbstract;
use Zenomania\CoreBundle\Entity\Club;
use Zenomania\CoreBundle\Entity\Event;
use Zenomania\CoreBundle\Service\Utils\HostBasedUrl;

class EventPredictionTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['club_home', 'club_guest', 'players'];
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
            'id' => $event->getId(),
            'name' => $event->getName(),
            'date' => $event->getDate()->getTimestamp()
        ];
    }

    public function includeClubHome(Event $event)
    {
        return $this->item($event->getClubHome(), new ClubTransformer($this->url));
    }

    public function includeClubGuest(Event $event)
    {
        return $this->item($event->getClubGuest(), new ClubTransformer($this->url));
    }

    public function includePlayers(Event $event)
    {
        $club = null;
        /** @var Club $item */
        foreach ([$event->getClubHome(), $event->getClubGuest()] as $item) {
            if ($item->getLineUpAvailable()) {
                $club = $item;
                break;
            }
        }
        if (null === $club) {// no players
            return null;
        }

        return $this->collection($club->getPlayers(), new PlayerTransformer($this->url));
    }
}