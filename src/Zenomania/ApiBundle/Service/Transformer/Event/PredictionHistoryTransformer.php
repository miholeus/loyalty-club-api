<?php
/**
 * @package    Zenomania\ApiBundle\Service\Transformer\Event
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service\Transformer\Event;

use Zenomania\ApiBundle\Service\Transformer\ClubTransformer;
use Zenomania\ApiBundle\Service\Transformer\PlayerTransformer;
use Zenomania\ApiBundle\Service\Transformer\TransformerAbstract;
use Zenomania\CoreBundle\Entity\Event;
use Zenomania\CoreBundle\Service\Utils\HostBasedUrl;

class PredictionHistoryTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['club_home', 'club_guest', 'mvp', 'lineup', 'forecast'];
    /**
     * @var HostBasedUrl
     */
    private $url;
    /**
     * @var EventForecastTransformer
     */
    private $eventForecastTransformer;

    public function __construct(
        HostBasedUrl $url,
        EventForecastTransformer $eventForecastTransformer
    )
    {
        $this->url = $url;
        $this->eventForecastTransformer = $eventForecastTransformer;
    }

    public function transform(Event $event)
    {
        return [
            'id' => $event->getId(),
            'name' => $event->getName(),
            'date' => $event->getDate()->getTimestamp(),
            'score' => [
                'home' => $event->getScoreHome(),
                'guest' => $event->getScoreGuest()
            ],
            'roundScore' => $this->getRoundScore($event->getScoreInRounds())
        ];
    }

    /**
     * Клуб, принимающий гостя
     *
     * @param Event $event
     * @return \League\Fractal\Resource\Item
     */
    public function includeClubHome(Event $event)
    {
        return $this->item($event->getClubHome(), new ClubTransformer($this->url));
    }

    /**
     * Клуб гость
     *
     * @param Event $event
     * @return \League\Fractal\Resource\Item
     */
    public function includeClubGuest(Event $event)
    {
        return $this->item($event->getClubGuest(), new ClubTransformer($this->url));
    }

    /**
     * Получаем mvp игрока
     *
     * @param Event $event
     * @return \League\Fractal\Resource\Item|null
     */
    public function includeMvp(Event $event)
    {
        if (null === $event->getMvp()) {
            return null;
        }
        return $this->item($event->getMvp(), new PlayerTransformer($this->url));
    }

    /**
     * Получаем данные по стартовому составу
     *
     * @param Event $event
     * @return \League\Fractal\Resource\Collection
     */
    public function includeLineup(Event $event)
    {
        $lineup = $this->collection($event->getLineUp()->toArray(), new LineUpTransformer($this->url));
        return $lineup;
    }

    /**
     * Получаем данные с прогнозом счёта матча и каждой партии
     *
     * @param Event $event
     * @return \League\Fractal\Resource\Item|null
     */
    public function includeForecast(Event $event)
    {
        return $this->item($event, $this->getEventForecastTransformer());
    }

    /**
     * Преобразует строку с данными о результате партий в массив
     *
     * @param string $str
     * @return array
     */
    private function getRoundScore(string $str)
    {
        $rounds = explode(',', $str);
        $i = 1;
        $roundScore = [];
        foreach ($rounds as $round) {
            $score = explode(':', $round);
            $roundScore[] = [
                'round' => $i,
                'home' => (int) $score[0],
                'guest' => (int) $score[1]
            ];
            $i++;
        }

        return $roundScore;
    }

    /**
     * @return EventForecastTransformer
     */
    public function getEventForecastTransformer(): EventForecastTransformer
    {
        return $this->eventForecastTransformer;
    }
}