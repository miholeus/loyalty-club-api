<?php
/**
 * @package    Zenomania\ApiBundle\Service
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service;

use Doctrine\ORM\EntityManager;
use Zenomania\ApiBundle\Service\Exception\EntityNotFoundException;
use Zenomania\CoreBundle\Entity\Event;
use Zenomania\CoreBundle\Entity\EventForecast;
use Zenomania\CoreBundle\Entity\LineUp;
use Zenomania\CoreBundle\Entity\PersonPoints;
use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Repository\EventForecastRepository;
use Zenomania\CoreBundle\Repository\EventRepository;
use Zenomania\CoreBundle\Repository\UserRepository;
use Zenomania\CoreBundle\Repository\PersonPointsRepository;
use Zenomania\ApiBundle\Service\PersonPoints as PersonPointsService;
use Zenomania\CoreBundle\Repository\EventPlayerForecastRepository;

class Events
{
    /**
     * @var EventRepository
     */
    private $eventRepository;

    /** @var EventForecastRepository */
    private $eventForecastRepository;

    /** @var UserRepository */
    private $userRepository;

    /** @var PersonPointsRepository  */
    private $personPointsRepository;

    /** @var EntityManager */
    private $em;

    /** @var EventPlayerForecastRepository  */
    private $eventPlayerForecastRepository;

    public function __construct(EventRepository $eventRepository, EntityManager $em)
    {
        $this->eventRepository = $eventRepository;
        $this->em = $em;
        $this->eventForecastRepository = $em->getRepository('ZenomaniaCoreBundle:EventForecast');
        $this->userRepository = $em->getRepository('ZenomaniaCoreBundle:User');
        $this->personPointsRepository = $em->getRepository('ZenomaniaCoreBundle:PersonPoints');
        $this->eventPlayerForecastRepository = $em->getRepository('ZenomaniaCoreBundle:EventPlayerForecast');
    }

    /**
     * Finds next event
     *
     * @return null|\Zenomania\CoreBundle\Event\Event
     * @throws EntityNotFoundException
     */
    public function nextEvent()
    {
        $dt = new \DateTimeImmutable();
        $event = $this->getEventRepository()->findNextEvent($dt);

        if (null === $event) {
            throw EntityNotFoundException::eventNotFound();
        }
        return $event;
    }

    /**
     * Saves Event
     *
     * @param \Zenomania\CoreBundle\Entity\Event $event
     */
    public function save(\Zenomania\CoreBundle\Entity\Event $event)
    {

        if ($event->getLineUp()->count() > 0) {
            $event->setIsLineUp(true);
        } else {
            $event->setIsLineUp(false);
        }

        $this->cleanLineUpJunk($event);
        $this->getEventRepository()->save($event);
    }

    /**
     * Удаление стартового состава, который более не привязан к матчу
     *
     * @param \Zenomania\CoreBundle\Entity\Event $event
     */
    private function cleanLineUpJunk(\Zenomania\CoreBundle\Entity\Event $event)
    {
        $originalCollection = $this->getEventRepository()->findLineUp($event);
        $currentCollection = $event->getLineUp();
        $currentIdList = [];

        foreach ($currentCollection as $item) {
            $currentIdList[] = $item->getId();
        }

        foreach ($originalCollection as $item) {
            if (!in_array($item->getId(), $currentIdList)) {
                $this->getEventRepository()->removeLineUp($item);
            }
        }
    }
    /**
     * @return EventRepository
     */
    public function getEventRepository(): EventRepository
    {
        return $this->eventRepository;
    }

    /**
     * @param Event $event
     * @return int
     */
    public function calculate(Event $event)
    {
        // Получить все прогнозы для события $event
        $eventForecast = $this->getEventForecastRepository()->getEventForecastByEvent($event);

        // Обработать каждый прогноз и начислить очки
        /** @var EventForecast $forecast */
        foreach ($eventForecast as $forecast) {
            /** @var User $user */
            $user = $this->getUserRepository()->find($forecast->getUser());

            if (empty($user)) {
                continue;
            }

            // Проверить предсказан ли победитель матча и начислить очки
            if ($this->predictedWinner($forecast, $event)) {
                $points = PersonPointsService::POINTS_FOR_PREDICTION_MATCH_RESULT;
                $type = PersonPoints::TYPE_FORECAST_WINNER_MATCH_RESULT;
                $this->getPersonPointsRepository()->givePointsForForecast($user, $points, $type);
            }

            // Проверить предсказан ли точный счёт матча и начислить очки
            if ($this->predictedExactScore($forecast, $event)) {
                $points = PersonPointsService::POINTS_FOR_PREDICTION_MATCH_ROUNDS;
                $type = PersonPoints::TYPE_FORECAST_WINNER_MATCH_ROUNDS;
                $this->getPersonPointsRepository()->givePointsForForecast($user, $points, $type);
            }

            // Проверить в скольки раундах точно предсказан счёт и начислить очки
            if ($predictedRound = $this->predictedScoreInRound($forecast, $event)) {
                $points = PersonPointsService::POINTS_FOR_PREDICTION_MATCH_ROUND_SCORE;
                $type = PersonPoints::TYPE_FORECAST_WINNER_MATCH_ROUND_SCORE;
                $this->getPersonPointsRepository()->givePointsForForecast($user, $points * $predictedRound, $type);
            }

            $this->processe($forecast);
        }


        // Выбрать стартовый состав для мероприятия $event
        $lineUp = $this->getEventRepository()->findLineUp($event);

        // Собрать игроков стартового состава в массив
        $idPlayers = [];
        /** @var LineUp $player */
        foreach ($lineUp as $item) {
            $idPlayers[] = $item->getPlayer()->getId();
        }

        // Получить массив с данными
        $predictedPlayers = $this->getEventPlayerForecastRepository()->getAmountOfPredictedPlayers($event, $idPlayers);
var_dump($predictedPlayers);
        exit;
        foreach ($predictedPlayers as $item) {
            $user = $this->getUserRepository()->find($item['user']);
            $points = PersonPoints::POINTS_FOR_PREDICTION_ONE_PLAYER; // Сколько начислить баллов за предсказанного игрока стартового состава
            $this->getPersonPointsRepository()->givePointsForForecast($user, $points * $item['cnt'], 'forecast_winner_one_player');
        }


        $predictedMvp = $this->getEm()->getRepository('ZenomaniaCoreBundle:EventPlayerForecast')->getPredictedMvp($event);

        foreach ($predictedMvp as $item) {
            $user = $this->getUserRepository()->find($item['user']);
            $points = PersonPoints::POINTS_FOR_PREDICTION_MATCH_MVP; // Сколько начислить баллов за предсказанного результативного игрока
            $this->getPersonPointsRepository()->givePointsForForecast($user, $points, 'forecast_winner_mvp');
        }

        $event->setScoreSaved(1);

        return 100;
    }

    /**
     * Проверяет был ли в прогнозе верно указан победитель матча
     *
     * @param EventForecast $forecast
     * @param Event $event
     * @return bool
     */
    protected function predictedWinner(EventForecast $forecast, Event $event)
    {
        $forecastWinner = $forecast->getScoreHome() - $forecast->getScoreGuest();
        $eventWinner = $event->getScoreHome() - $event->getScoreGuest();

        if (($forecastWinner * $eventWinner) > 0) {
            return true;
        }

        return false;
    }

    /**
     * Считает сколько партий в матче было угадано пользователем
     *
     * @param EventForecast $forecast
     * @param Event $event
     * @return int
     */
    protected function predictedScoreInRound(EventForecast $forecast, Event $event)
    {
        $count = 0;
        $forecastRounds = explode(';', $forecast->getScoreInRounds());
        $eventRounds = explode(';', $event->getScoreInRounds());
        foreach ($forecastRounds as $round => $score) {
            if ($score == $eventRounds[$round]) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * Проверяет был ли в прогнозе верно указан счёт матча
     *
     * @param EventForecast $forecast
     * @param Event $event
     * @return bool
     */
    protected function predictedExactScore(EventForecast $forecast, Event $event)
    {
        $predictedScoreHome = ($forecast->getScoreHome() == $event->getScoreHome());
        $predictedScoreGuest =  ($forecast->getScoreGuest() == $event->getScoreGuest());

        if ($predictedScoreHome && $predictedScoreGuest) {
            return true;
        }

        return false;
    }

    /**
     * @return EventForecastRepository
     */
    public function getEventForecastRepository()
    {
        return $this->eventForecastRepository;
    }

    /**
     * @return UserRepository
     */
    public function getUserRepository()
    {
        return $this->userRepository;
    }

    /**
     * @return PersonPointsRepository
     */
    public function getPersonPointsRepository()
    {
        return $this->personPointsRepository;
    }

    /**
     * @return EntityManager
     */
    public function getEm()
    {
        return $this->em;
    }

    private function processe(EventForecast $forecast)
    {
        $forecast->setUpdatedOn(new \DateTime());
        $forecast->setStatus(EventForecast::STATUS_PROCESSED);
        $this->getEventForecastRepository()->save($forecast);
    }

    /**
     * @return EventPlayerForecastRepository
     */
    public function getEventPlayerForecastRepository()
    {
        return $this->eventPlayerForecastRepository;
    }
}