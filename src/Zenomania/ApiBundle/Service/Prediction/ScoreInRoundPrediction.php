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

class ScoreInRoundPrediction extends AbstractPrediction implements PredictionPointsInterface
{
    /**
     * Считает сколько партий в матче было угадано пользователем
     *
     * @param EventForecast $forecast
     * @return bool
     */
    public function supports(EventForecast $forecast): bool
    {
        $forecastRounds = explode(';', $forecast->getScoreInRounds());
        $event = $forecast->getEvent();
        $eventRounds = explode(';', $event->getScoreInRounds());

        return $forecastRounds == $eventRounds;
    }

    /**
     * @param EventForecast $forecast
     * @param User $user
     * @return mixed|void
     */
    public function givePoints(EventForecast $forecast, User $user)
    {
        $points = PersonPointsService::POINTS_FOR_PREDICTION_MATCH_ROUND_SCORE;
        $type = PersonPoints::TYPE_FORECAST_WINNER_MATCH_ROUND_SCORE;
        $predictedRound = $this->getNumberOfRoundsPredicted($forecast);
        $this->getRepository()->givePointsForForecast($user, $points * $predictedRound, $type);
    }

    /**
     * Number of rounds predicted
     *
     * @param EventForecast $forecast
     * @return int
     */
    private function getNumberOfRoundsPredicted(EventForecast $forecast)
    {
        $count = 0;
        $event = $forecast->getEvent();
        $forecastRounds = explode(';', $forecast->getScoreInRounds());
        $eventRounds = explode(';', $event->getScoreInRounds());
        foreach ($forecastRounds as $round => $score) {
            if ($score == $eventRounds[$round]) {
                $count++;
            }
        }
        return $count;
    }
}