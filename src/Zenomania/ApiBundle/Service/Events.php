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
use Zenomania\CoreBundle\Entity\EventPlayerForecast;
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
        $this->em = $em;
        $this->eventRepository = $eventRepository;
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
     */
    public function calculate(Event $event)
    {
        if ($this->isNotCalculate($event)) {
            return;
        }

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
                $this->addPointsForPredictedWinner($user);
            }

            // Проверить предсказан ли точный счёт матча и начислить очки
            if ($this->predictedExactScore($forecast, $event)) {
                $this->addPointsForPredictedScore($user);
            }

            // Проверить в скольки раундах точно предсказан счёт и начислить очки
            if ($predictedRound = $this->predictedScoreInRound($forecast, $event)) {
                $this->addPointsForPredictedScoreInRound($user, $predictedRound);
            }

            // Устанавливаем статус прогноза как обработанный
            $this->processeForecast($forecast);
        }

        // Получить массив id игроков стартового состава
        $idPlayers = $this->getPlayersLineUp($event);

        // Получить массив с данными: пользователь -> количество предсказанных игроков
        $predictedPlayers = $this->getEventPlayerForecastRepository()->getAmountOfPredictedPlayers($event, $idPlayers);

        foreach ($predictedPlayers as $item) {
            $this->addPointsForPredictedPlayers($item);
            $this->processePlayerForecast($event, $item['user']);
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

    private function processeForecast(EventForecast $forecast)
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

    private function processePlayerForecast($event, $userId)
    {
        $user = $this->getUserRepository()->find($userId);
        /** @var EventPlayerForecast */
        $playerForecast = $this->getEventPlayerForecastRepository()->findBy(['event' => $event, 'user' => $user]);
        $this->getEventPlayerForecastRepository()->updateForecasts($playerForecast);
    }

    /**
     * @param $user
     */
    private function addPointsForPredictedWinner($user)
    {
        $points = PersonPointsService::POINTS_FOR_PREDICTION_MATCH_RESULT;
        $type = PersonPoints::TYPE_FORECAST_WINNER_MATCH_RESULT;
        $this->getPersonPointsRepository()->givePointsForForecast($user, $points, $type);
    }

    /**
     * @param $user
     */
    private function addPointsForPredictedScore($user)
    {
        $points = PersonPointsService::POINTS_FOR_PREDICTION_MATCH_ROUNDS;
        $type = PersonPoints::TYPE_FORECAST_WINNER_MATCH_ROUNDS;
        $this->getPersonPointsRepository()->givePointsForForecast($user, $points, $type);
    }

    /**
     * @param $user
     * @param $predictedRound
     */
    private function addPointsForPredictedScoreInRound($user, $predictedRound)
    {
        $points = PersonPointsService::POINTS_FOR_PREDICTION_MATCH_ROUND_SCORE;
        $type = PersonPoints::TYPE_FORECAST_WINNER_MATCH_ROUND_SCORE;
        $this->getPersonPointsRepository()->givePointsForForecast($user, $points * $predictedRound, $type);
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
        $event->setScoreSaved(EventRepository::SCORE_SAVED_PROCESSED);
        $this->getEventRepository()->save($event);
    }

    /**
     * @param array $item
     */
    private function addPointsForPredictedPlayers(array $item)
    {
        /** @var User $user */
        $user = $this->getUserRepository()->find($item['user']);
        $points = PersonPointsService::POINTS_FOR_PREDICTION_ONE_PLAYER;
        $type = PersonPoints::TYPE_FORECAST_WINNER_ONE_PLAYER;
        $this->getPersonPointsRepository()->givePointsForForecast($user, $points * $item['cnt'], $type);
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
     * @return bool
     */
    private function isNotCalculate(Event $event)
    {
        if ($event->getScoreSaved() == EventRepository::SCORE_SAVED_PROCESSED) {
            return true;
        }

        if ((!in_array($event->getScoreHome(), [0, 1, 2, 3]))) {
            return true;
        }

        if ((!in_array($event->getScoreGuest(), [0, 1, 2, 3]))) {
            return true;
        }

        return false;
    }
}