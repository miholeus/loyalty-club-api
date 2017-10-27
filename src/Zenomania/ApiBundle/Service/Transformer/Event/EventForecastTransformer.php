<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 25.10.2017
 * Time: 12:09
 */

namespace Zenomania\ApiBundle\Service\Transformer\Event;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Zenomania\ApiBundle\Service\Transformer\TransformerAbstract;
use Zenomania\CoreBundle\Entity\Event;
use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Repository\EventForecastRepository;
use Zenomania\CoreBundle\Service\Utils\HostBasedUrl;

class EventForecastTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['lineup', 'mvp'];
    /**
     * @var HostBasedUrl
     */
    private $url;
    /**
     * @var EventForecastRepository
     */
    private $eventForecastRepository;
    /**
     * @var TokenStorage
     */
    private $tokenStorage;
    /**
     * @var LineUpForecastTransformer
     */
    private $lineUpTransformer;
    /**
     * @var LineUpMvpForecastTransformer
     */
    private $lineUpMvpForecastTransformer;

    public function __construct(
        HostBasedUrl $url,
        EventForecastRepository $eventForecastRepository,
        TokenStorage $tokenStorage,
        LineUpForecastTransformer $lineUpTransformer,
        LineUpMvpForecastTransformer $lineUpMvpForecastTransformer
    )
    {
        $this->url = $url;
        $this->eventForecastRepository = $eventForecastRepository;
        $this->tokenStorage = $tokenStorage;
        $this->lineUpTransformer = $lineUpTransformer;
        $this->lineUpMvpForecastTransformer = $lineUpMvpForecastTransformer;
    }

    public function transform(Event $event)
    {
        $forecast = $this->getEventForecastRepository()->getEventForecast($event, $this->getUser());
        if (null !== $forecast) {
            return [
                'score' => [
                    'home' => $forecast->getScoreHome(),
                    'guest' => $forecast->getScoreGuest()
                ],
                'roundScore' => $this->getRoundScore($forecast->getScoreInRounds())
            ];
        }
        return null;
    }

    /**
     * Прогноз по составу
     *
     * @param Event $event
     * @return \League\Fractal\Resource\Item
     */
    public function includeLineup(Event $event)
    {
        return $this->getLineUpTransformer()->transform($event);
    }

    /**
     * Прогноз по mvp игроку
     *
     * @param Event $event
     * @return \League\Fractal\Resource\Item
     */
    public function includeMvp(Event $event)
    {
        return $this->getLineUpMvpForecastTransformer()->transform($event);
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
     * @return LineUpForecastTransformer
     */
    public function getLineUpTransformer(): LineUpForecastTransformer
    {
        return $this->lineUpTransformer;
    }

    /**
     * @return LineUpMvpForecastTransformer
     */
    public function getLineUpMvpForecastTransformer(): LineUpMvpForecastTransformer
    {
        return $this->lineUpMvpForecastTransformer;
    }
}