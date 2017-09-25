<?php
/**
 * @package    Zenomania\ApiBundle\Service
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service;

use Zenomania\ApiBundle\Form\Model\EventScorePrediction;
use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Entity\Event;
use Zenomania\CoreBundle\Repository\EventForecastRepository;

class EventForecast
{
    /**
     * @var EventForecastRepository
     */
    private $repository;

    public function __construct(EventForecastRepository $repository)
    {
        $this->repository = $repository;
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
     * Checks if user has made forecast
     *
     * @param Event $event
     * @param User $user
     * @return bool
     */
    public function hasActiveForecast(Event $event, User $user) : bool
    {
        $forecast = $this->getRepository()->getEventForecast($event, $user);

        if (null !== $forecast) {
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
        $this->getRepository()->save($forecast);
    }
    /**
     * @return EventForecastRepository
     */
    public function getRepository(): EventForecastRepository
    {
        return $this->repository;
    }
}