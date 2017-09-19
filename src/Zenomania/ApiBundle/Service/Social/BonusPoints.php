<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 13.09.17
 * Time: 17:53
 */

namespace Zenomania\ApiBundle\Service\Social;

use Zenomania\ApiBundle\Service\PersonPoints;
use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Repository\PersonPointsRepository;

class BonusPoints
{
    /**
     * @var PersonPointsRepository
     */
    private $personPointsRepository;

    public function __construct(PersonPointsRepository $personPointsRepository)
    {
        $this->personPointsRepository = $personPointsRepository;
    }

    /**
     * Начисляем пользователю баллы лояльности за привязку соц сети
     *
     * @param User $user пользователь который привязал свою соц сеть
     * @return int
     */
    public function givePointsForSocialBind(User $user)
    {
        $this->getPersonPointsRepository()->givePointsForSocialBind($user, PersonPoints::POINTS_FOR_SOCIAL_BIND);

        return PersonPoints::POINTS_FOR_SOCIAL_BIND;
    }

    /**
     * @return PersonPointsRepository
     */
    public function getPersonPointsRepository(): PersonPointsRepository
    {
        return $this->personPointsRepository;
    }
}