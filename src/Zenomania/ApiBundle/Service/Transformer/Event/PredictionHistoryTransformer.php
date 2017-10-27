<?php
/**
 * @package    Zenomania\ApiBundle\Service\Transformer\Event
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */


namespace Zenomania\ApiBundle\Service\Transformer\Event;


use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Zenomania\ApiBundle\Service\Transformer\ClubTransformer;
use Zenomania\ApiBundle\Service\Transformer\PlayerTransformer;
use Zenomania\ApiBundle\Service\Transformer\TransformerAbstract;
use Zenomania\CoreBundle\Entity\Event;
use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Repository\EventForecastRepository;
use Zenomania\CoreBundle\Repository\EventPlayerForecastRepository;
use Zenomania\CoreBundle\Service\Utils\HostBasedUrl;

class PredictionHistoryTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['club_home', 'club_guest', 'mvp', 'lineup', 'forecast'];
    /**
     * @var HostBasedUrl
     */
    private $url;
    /**
     * @var EventForecastRepository
     */
    private $eventForecastRepository;
    /**
     * @var EventPlayerForecastRepository
     */
    private $eventPlayerForecastRepository;
    /**
     * @var TokenStorage
     */
    private $tokenStorage;

    public function __construct(
        HostBasedUrl $url,
        EventForecastRepository $eventForecastRepository,
        EventPlayerForecastRepository $eventPlayerForecastRepository,
        TokenStorage $tokenStorage
    )
    {
        $this->url = $url;
        $this->eventForecastRepository = $eventForecastRepository;
        $this->eventPlayerForecastRepository = $eventPlayerForecastRepository;
        $this->tokenStorage = $tokenStorage;
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
        $forecastScore = $this->getEventForecastRepository()->getEventForecast($event, $this->getUser());
        if (null !== $forecastScore) {
            return $this->item($forecastScore, new EventForecastTransformer($this->url));
        }
        return null;
    }

    /**
     * Возвращает текущего пользователя
     *
     * @return User
     */
    protected function getUser()
    {
        return $this->tokenStorage->getToken()->getUser();
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
     * @return EventForecastRepository
     */
    public function getEventForecastRepository(): EventForecastRepository
    {
        return $this->eventForecastRepository;
    }

    /**
     * @return EventPlayerForecastRepository
     */
    public function getEventPlayerForecastRepository(): EventPlayerForecastRepository
    {
        return $this->eventPlayerForecastRepository;
    }
}