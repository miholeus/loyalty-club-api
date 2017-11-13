<?php
/**
 * @package    Zenomania\ApiBundle\Service
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;
use Zenomania\ApiBundle\Service\Exception\EntityNotFoundException;
use Zenomania\ApiBundle\Service\Exception\PointsCanNotBeGrantedException;
use Zenomania\ApiBundle\Service\Prediction\{
    PredictionPointsInterface, ExactScorePrediction, ScoreInRoundPrediction, WinnerPrediction
};
use Zenomania\CoreBundle\Entity\{
    Event, EventForecast, EventPlayerForecast, LineUp, PersonPoints, User
};
use Zenomania\CoreBundle\Repository\{
    EventForecastRepository, EventRepository, UserRepository, PersonPointsRepository, EventPlayerForecastRepository
};
use Zenomania\ApiBundle\Service\PersonPoints as PersonPointsService;

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

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->eventRepository = $em->getRepository('ZenomaniaCoreBundle:Event');
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
     * Process predictions for event
     *
     * @param Event $event
     */
    public function processPredictions(Event $event)
    {
        $this->ensurePointsCanBeGranted($event);

        // Получить все прогнозы для события $event
        $forecasts = $this->getEventForecastRepository()->getForecasts($event);

        $predictions = [
            new WinnerPrediction($this->getPersonPointsRepository()),
            new ExactScorePrediction($this->getPersonPointsRepository()),
            new ScoreInRoundPrediction($this->getPersonPointsRepository())
        ];

        // Обработать каждый прогноз и начислить очки
        /** @var EventForecast $forecast */
        foreach ($forecasts as $forecast) {
            $user = $forecast->getUser();

            if (empty($user)) {
                continue;
            }

            /** @var PredictionPointsInterface $prediction */
            foreach ($predictions as $prediction) {
                if ($prediction->supports($forecast)) {
                    $prediction->givePoints($forecast, $user);
                }
            }

            // Устанавливаем статус прогноза как обработанный
            $this->processForecast($forecast);
        }

        // Получить массив id игроков стартового состава
        $idPlayers = $this->getPlayersLineUp($event);

        // Получить массив с данными: пользователь -> количество предсказанных игроков
        $predictedPlayers = $this->getEventPlayerForecastRepository()->getAmountOfPredictedPlayers($event, $idPlayers);

        foreach ($predictedPlayers as $item) {
            $this->addPointsForPredictedPlayers($item['user'], $item['cnt']);
            $this->processPlayerForecast($event, $item['user']);
        }

        // Получить массив пользователей, которые угадали результативного игрока
        $predictedMvp = $this->getEventPlayerForecastRepository()->getPredictedMvp($event);

        foreach ($predictedMvp as $item) {
            $user = $this->getUserRepository()->find($item['user']);
            $this->addPointsForPredictedMvp($user);
        }

        // Установить событию метку как обработанное для подсчёта прогнозов
        $this->processedEvent($event);
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

    private function processForecast(EventForecast $forecast)
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

    private function processPlayerForecast($event, $userId)
    {
        $user = $this->getUserRepository()->find($userId);
        /** @var EventPlayerForecast */
        $playerForecast = $this->getEventPlayerForecastRepository()->findBy(['event' => $event, 'user' => $user]);
        $this->getEventPlayerForecastRepository()->updateForecasts($playerForecast);
    }

    /**
     * @param $user
     */
    private function addPointsForPredictedMvp($user)
    {
        $points = PersonPointsService::POINTS_FOR_PREDICTION_MATCH_MVP;
        $type = PersonPoints::TYPE_FORECAST_WINNER_MVP;
        $this->getPersonPointsRepository()->givePointsForForecast($user, $points, $type);
    }

    /**
     * @param Event $event
     */
    private function processedEvent(Event $event)
    {
        $event->setScoreSaved(Event::SCORE_SAVED_PROCESSED);
        $this->getEventRepository()->save($event);
    }

    /**
     * @param $userId
     * @param $playersNumber
     */
    private function addPointsForPredictedPlayers($userId, $playersNumber)
    {
        /** @var User $user */
        $user = $this->getUserRepository()->find($userId);
        $points = PersonPointsService::POINTS_FOR_PREDICTION_ONE_PLAYER;
        $type = PersonPoints::TYPE_FORECAST_WINNER_ONE_PLAYER;
        $this->getPersonPointsRepository()->givePointsForForecast($user, $points * $playersNumber, $type);
    }

    /**
     * @param Event $event
     * @return array
     */
    private function getPlayersLineUp(Event $event)
    {
        // Выбрать стартовый состав для мероприятия $event
        $lineUp = $this->getEventRepository()->findLineUp($event);

        // Собрать id игроков стартового состава заданного мероприятия в массив
        $idPlayers = [];
        /** @var LineUp $player */
        foreach ($lineUp as $item) {
            $idPlayers[] = $item->getPlayer()->getId();
        }
        return $idPlayers;
    }

    /**
     * @param Event $event
     * @throws PointsCanNotBeGrantedException
     * @return bool
     */
    private function ensurePointsCanBeGranted(Event $event)
    {
        if ($event->getScoreSaved() == Event::SCORE_SAVED_PROCESSED) {
            throw new PointsCanNotBeGrantedException("Событие уже обработано");
        }

        if ($event->getDate()->getTimestamp() > time()) {
            throw new PointsCanNotBeGrantedException("Событие еще не закончилось");
        }

        return true;
    }

    /**
     * Get points for predictions for event
     *
     * @param Event $event
     * @param User $user
     * @return int|null
     */
    public function getPointsForPredictions(Event $event, User $user)
    {
        if ($event->getScoreSaved() != Event::SCORE_SAVED_PROCESSED) {
            return null;
        }

        $points = 0;

        // Получить все прогнозы для события $event
        $forecast = $this->getEventForecastRepository()->getEventForecast($event, $user);

        $predictions = [
            new WinnerPrediction($this->getPersonPointsRepository()),
            new ExactScorePrediction($this->getPersonPointsRepository()),
            new ScoreInRoundPrediction($this->getPersonPointsRepository())
        ];


        /** @var PredictionPointsInterface $prediction */
        foreach ($predictions as $prediction) {
            if ($prediction->supports($forecast)) {
                $points += $prediction->getPoints($forecast);
            }
        }


        // Получить массив id игроков стартового состава
        $idPlayers = $this->getPlayersLineUp($event);

        try {
            // Получить массив с данными: пользователь -> количество предсказанных игроков
            $predictedPlayers = $this->getEventPlayerForecastRepository()->getAmountOfPredictedPlayersForUser($event, $idPlayers, $user);

            $points += (PersonPointsService::POINTS_FOR_PREDICTION_ONE_PLAYER * $predictedPlayers);
        } catch (NoResultException $e) {
            // no points
        }

        // Получить массив пользователей, которые угадали результативного игрока
        $predictedMvp = $this->getEventPlayerForecastRepository()->getPredictedMvpByUser($event, $user);

        if (!empty($predictedMvp)) {
            $points += PersonPointsService::POINTS_FOR_PREDICTION_MATCH_MVP;
        }

        return $points;
    }
}