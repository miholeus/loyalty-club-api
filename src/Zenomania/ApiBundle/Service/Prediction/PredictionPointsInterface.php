<?php
/**
 * @package    Zenomania\ApiBundle\Service\Prediction
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service\Prediction;

use Zenomania\CoreBundle\Entity\EventForecast;
use Zenomania\CoreBundle\Entity\User;

interface PredictionPointsInterface
{
    /**
     * Checks if points can be granted
     *
     * @param EventForecast $forecast
     * @return bool
     */
    public function supports(EventForecast $forecast): bool;

    /**
     * Grant points to user for forecast event
     *
     * @param EventForecast $forecast
     * @param User $user
     * @return mixed
     */
    public function givePoints(EventForecast $forecast, User $user);

    /**
     * Get points for forecast event
     *
     * @param EventForecast $forecast
     * @return mixed
     */
    public function getPoints(EventForecast $forecast);
}