<?php
/**
 * @package    Zenomania\ApiBundle\Service\Prediction
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service\Prediction;

use Zenomania\CoreBundle\Entity\EventForecast;
use Zenomania\CoreBundle\Entity\PersonPoints;
use Zenomania\CoreBundle\Entity\User;
use Zenomania\ApiBundle\Service\PersonPoints as PersonPointsService;

class WinnerPrediction extends AbstractPrediction implements PredictionPointsInterface
{
    /**
     * Проверяет был ли в прогнозе верно указан победитель матча
     *
     * @param EventForecast $forecast
     * @return bool
     */
    public function supports(EventForecast $forecast): bool
    {
        $forecastWinner = $forecast->getScoreHome() > $forecast->getScoreGuest();
        $event = $forecast->getEvent();
        $eventWinner = $event->getScoreHome() > $event->getScoreGuest();

        return $forecastWinner === $eventWinner;
    }

    /**
     * @param EventForecast $forecast
     * @param User $user
     * @return mixed|void
     */
    public function givePoints(EventForecast $forecast, User $user)
    {
        $points = PersonPointsService::POINTS_FOR_PREDICTION_MATCH_RESULT;
        $type = PersonPoints::TYPE_FORECAST_WINNER_MATCH_RESULT;
        $this->getRepository()->givePointsForForecast($user, $points, $type);
    }

    public function getPoints(EventForecast $forecast)
    {
        return PersonPointsService::POINTS_FOR_PREDICTION_MATCH_RESULT;
    }
}