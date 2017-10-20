<?php
/**
 * @package    Zenomania\ApiBundle\Service
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service;

use Zenomania\ApiBundle\Service\Utils\PeriodConverter;
use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Repository\PersonPointsRepository;

class PersonPoints
{
    const POINTS_FOR_INVITE = 10;// Сколько начислить баллов за регистрацию по реферальному коду
    const POINTS_FOR_SOCIAL_BIND = 10;// Сколько начислить баллов за привязку соц сети
    const POINTS_FOR_TICKET_REGISTRATION = 100;
    const POINTS_FOR_SUBSCRIPTION_REGISTRATION = 200;
    const PERCENT_FOR_SUBSCRIPTION_REGISTRATION = 10;
    const POINTS_FOR_PROMO_CODE_REGISTRATION = 50;
    const POINTS_FOR_PREDICTION_MAX = 50;

    const POINTS_FOR_PREDICTION_MATCH_RESULT = 3;// исход матча
    const POINTS_FOR_PREDICTION_ONE_PLAYER = 1;// состав на матч
    const POINTS_FOR_PREDICTION_MATCH_ROUND_SCORE = 5;// счет в партиях 5 зен за угаданную партию
    const POINTS_FOR_PREDICTION_MATCH_ROUNDS = 5;// итоговый результат матча по партиям
    const POINTS_FOR_PREDICTION_MATCH_MVP = 5;// самый результативный игрок
    /**
     * @var PersonPointsRepository
     */
    private $repository;

    public function __construct(PersonPointsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function pointsForActions()
    {
        return [
            'ticket_registration' => self::POINTS_FOR_TICKET_REGISTRATION,
            'subscription_registration' => self::POINTS_FOR_SUBSCRIPTION_REGISTRATION,
            'promo_code_registration' => self::POINTS_FOR_PROMO_CODE_REGISTRATION,
            'prediction' => self::POINTS_FOR_PREDICTION_MAX,
            'invite_friend' => self::POINTS_FOR_INVITE
        ];
    }

    /**
     * Fetches user points
     *
     * @param User $user
     * @param \Zenomania\ApiBundle\Request\Filter\ProfileStatsFilter $filter
     * @return array
     */
    public function getUserPoints(User $user, \Zenomania\ApiBundle\Request\Filter\ProfileStatsFilter $filter = null) : array
    {
        $date = null;
        if (null !== $filter && null !== $filter->period) {
            $periodConverter = new PeriodConverter(PeriodConverter::LAST_INTERVAL, ['interval' => $filter->period]);
            $date = $periodConverter->getStartDate();
        }

        $data = $this->getRepository()->getUserPointsByType($user, $date);
        return $data ?? [];
    }

    /**
     * @return PersonPointsRepository
     */
    public function getRepository(): PersonPointsRepository
    {
        return $this->repository;
    }
}