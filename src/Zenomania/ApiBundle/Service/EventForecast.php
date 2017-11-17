<?php
/**
 * @package    Zenomania\ApiBundle\Service
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service;

use Zenomania\ApiBundle\Form\Model\EventScorePrediction;
use Zenomania\CoreBundle\Entity\EventPlayerForecast;
use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Entity\Event;
use Zenomania\CoreBundle\Repository\EventForecastRepository;
use Zenomania\CoreBundle\Repository\EventPlayerForecastRepository;

class EventForecast
{
    /**
     * @var EventForecastRepository
     */
    private $eventForecastRepository;
    /**
     * @var EventPlayerForecastRepository
     */
    private $playerForecastRepository;

    public function __construct(EventForecastRepository $repository, EventPlayerForecastRepository $playerForecastRepository)
    {
        $this->eventForecastRepository = $repository;
        $this->playerForecastRepository = $playerForecastRepository;
    }

    /**
     * Forms forecast model by form
     *
     * @param EventScorePrediction $eventScorePrediction
     * @return \Zenomania\CoreBundle\Entity\EventForecast
     */
    public function getEventForecastByModel(EventScorePrediction $eventScorePrediction) : \Zenomania\CoreBundle\Entity\EventForecast
    {
        $forecast = new \Zenomania\CoreBundle\Entity\EventForecast();

        $forecast->setScoreHome($eventScorePrediction->getScoreHome())
                ->setScoreGuest($eventScorePrediction->getScoreGuest())
                ->setScoreInRounds($eventScorePrediction->getScoreInRounds());
        $forecast->setStatus(\Zenomania\CoreBundle\Entity\EventForecast::STATUS_NEW);
        return $forecast;
    }

    /**
     * Checks if user has made forecast of scores
     *
     * @param Event $event
     * @param User $user
     * @return bool
     */
    public function hasActiveForecast(Event $event, User $user) : bool
    {
        $forecast = $this->getEventForecastRepository()->getEventForecast($event, $user);

        if (null !== $forecast) {
            return true;
        }
        return false;
    }

    /**
     * Checks if user has made player's forecast
     *
     * @param Event $event
     * @param User $user
     * @return bool
     */
    public function hasActivePlayerForecast(Event $event, User $user) : bool
    {
        $records = $this->getPlayerForecastRepository()->getTotalForecastPlayers($event, $user);

        if (0 != $records) {
            return true;
        }
        return false;
    }
    /**
     * Saves user's forecast
     *
     * @param \Zenomania\CoreBundle\Entity\EventForecast $forecast
     */
    public function save(\Zenomania\CoreBundle\Entity\EventForecast $forecast)
    {
        $this->getEventForecastRepository()->save($forecast);
    }

    /**
     * Saves user's forecast for event player
     *
     * @param \Doctrine\Common\Collections\ArrayCollection $forecasts
     */
    public function savePlayerForecasts(\Doctrine\Common\Collections\ArrayCollection $forecasts)
    {
        $this->getPlayerForecastRepository()->saveForecasts($forecasts);
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
    public function getPlayerForecastRepository(): EventPlayerForecastRepository
    {
        return $this->playerForecastRepository;
    }

    /**
     * Получить прогноз для заданного мероприятия и пользователя
     *
     * @param Event $event
     * @param User $user
     * @return null|\Zenomania\CoreBundle\Entity\EventForecast
     */
    public function getEventForecastForUpdate(Event $event, User $user)
    {
        return $this->getEventForecastRepository()->getEventForecast($event, $user);
    }

    /**
     * @param EventScorePrediction $eventScorePrediction
     * @param \Zenomania\CoreBundle\Entity\EventForecast $forecast
     * @return \Zenomania\CoreBundle\Entity\EventForecast
     */
    public function updateForecast(EventScorePrediction $eventScorePrediction, \Zenomania\CoreBundle\Entity\EventForecast $forecast)
    {
        $forecast->setScoreHome($eventScorePrediction->getScoreHome())
            ->setScoreGuest($eventScorePrediction->getScoreGuest())
            ->setScoreInRounds($eventScorePrediction->getScoreInRounds());

        return $forecast;
    }

    /**
     * Updates user's forecast for event player
     *
     * @param \Doctrine\Common\Collections\ArrayCollection $forecasts
     */
    public function updatePlayerForecasts(\Doctrine\Common\Collections\ArrayCollection $forecasts)
    {
        $this->getPlayerForecastRepository()->saveForecasts($forecasts);

        /**
         * @var EventPlayerForecast $forecast
         */
        foreach ($forecasts as $forecast) {
            $eventPlayerForecast = $this->getPlayerForecastRepository()->getEventPlayerForecast($forecast->getEvent(), $forecast->getUser());
            if (!empty($eventPlayerForecast)) {
                $eventPlayerForecast->setPlayer($forecast->getPlayer());
                $eventPlayerForecast->setIsMvp($forecast->getIsMvp());
                $this->getPlayerForecastRepository()->save($eventPlayerForecast);
            }
        }
    }
}