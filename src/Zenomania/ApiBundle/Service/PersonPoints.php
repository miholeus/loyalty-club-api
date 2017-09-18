<?php
/**
 * @package    Zenomania\ApiBundle\Service
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service;

class PersonPoints
{
    const POINTS_FOR_INVITE = 10;// Сколько начислить баллов за регистрацию по реферальному коду
    const POINTS_FOR_SOCIAL_BIND = 10;// Сколько начислить баллов за привязку соц сети
    const POINTS_FOR_TICKET_REGISTRATION = 100;
    const POINTS_FOR_SUBSCRIPTION_REGISTRATION = 200;
    const POINTS_FOR_PROMO_CODE_REGISTRATION = 50;
    const POINTS_FOR_PREDICTION_MAX = 50;

    const POINTS_FOR_PREDICTION_MATCH_RESULT = 3;// исход матча
    const POINTS_FOR_PREDICTION_ONE_PLAYER = 1;// состав на матч
    const POINTS_FOR_PREDICTION_MATCH_ROUND_SCORE = 5;// счет в партиях 5 зен за угаданную партию
    const POINTS_FOR_PREDICTION_MATCH_ROUNDS = 5;// итоговый результат матча по партиям
    const POINTS_FOR_PREDICTION_MATCH_MVP = 5;// самый результативный игрок


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
}