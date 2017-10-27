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

class ExactScorePrediction extends AbstractPrediction implements PredictionPointsInterface
{
    /**
     * Проверяет был ли в прогнозе верно указан счёт матча
     *
     * @param EventForecast $forecast
     * @return bool
     */
    public function supports(EventForecast $forecast): bool
    {
        $event = $forecast->getEvent();
        $predictedScoreHome = ($forecast->getScoreHome() == $event->getScoreHome());
        $predictedScoreGuest =  ($forecast->getScoreGuest() == $event->getScoreGuest());

        if ($predictedScoreHome && $predictedScoreGuest) {
            return true;
        }

        return false;
    }

    /**
     * @param EventForecast $forecast
     * @param User $user
     * @return mixed|void
     */
    public function givePoints(EventForecast $forecast, User $user)
    {
        $points = PersonPointsService::POINTS_FOR_PREDICTION_MATCH_ROUNDS;
        $type = PersonPoints::TYPE_FORECAST_WINNER_MATCH_ROUNDS;
        $this->getRepository()->givePointsForForecast($user, $points, $type);
    }

    public function getPoints(EventForecast $forecast)
    {
        return PersonPointsService::POINTS_FOR_PREDICTION_MATCH_ROUNDS;
    }
}