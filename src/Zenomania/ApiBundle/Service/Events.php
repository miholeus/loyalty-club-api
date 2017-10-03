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
use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Repository\EventForecastRepository;
use Zenomania\CoreBundle\Repository\EventRepository;
use Zenomania\CoreBundle\Repository\UserRepository;
use Zenomania\CoreBundle\Repository\PersonPointsRepository;

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

    public function __construct(EventRepository $eventRepository, EntityManager $em)
    {
        $this->eventRepository = $eventRepository;
        $this->eventForecastRepository = $em->getRepository('ZenomaniaCoreBundle:EventForecast');
        $this->userRepository = $em->getRepository('ZenomaniaCoreBundle:User');
        $this->personPointsRepository = $em->getRepository('ZenomaniaCoreBundle:PersonPoints');
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
        $eventForecast = $this->getEventForecastRepository()->getEventForecastByEvent($event);
        /** @var EventForecast $forecast */
        foreach ($eventForecast as $forecast) {
            /** @var User $user */
            $user = $this->getUserRepository()->find($forecast->getUser());
            if (empty($user)) {
                continue;
            }

            if ($this->predictedWinner($forecast, $event)) {
                $points = PersonPoints::POINTS_FOR_PREDICTION_MATCH_RESULT; // Сколько начислить баллов за предсказанного победителя матча
                $this->getPersonPointsRepository()->givePointsForForecast($user, $points, 'forecast_winner_match_result');
            }

            if ($this->predictedExactScore($forecast, $event)) {
                $points = PersonPoints::POINTS_FOR_PREDICTION_MATCH_ROUNDS; // Сколько начислить баллов за предсказанный счёт матча
                $this->getPersonPointsRepository()->givePointsForForecast($user, $points, 'forecast_winner_match_rounds');
            }

            $predictedRound = $this->predictedScoreInRound($forecast, $event);
            $points = PersonPoints::POINTS_FOR_PREDICTION_MATCH_ROUND_SCORE; // Сколько начислить баллов за предсказанный счёт матча
            $this->getPersonPointsRepository()->givePointsForForecast($user, $points * $predictedRound, 'forecast_winner_match_round_score');

            // @todo Обновить таблицу event_forecast updated_on = new DateTime, status = 1

            // @todo Реализивать начисление за угаданного игрока стартового состава
            // @todo Реализовать начисление за угаданного самого результативного игрока
        }

        $event->setScoreSaved(1);
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
}