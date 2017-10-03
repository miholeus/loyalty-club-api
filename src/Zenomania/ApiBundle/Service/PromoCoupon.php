<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 29.09.2017
 * Time: 17:42
 */

namespace Zenomania\ApiBundle\Service;


use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Repository\PersonPointsRepository;
use Zenomania\CoreBundle\Repository\PromoCouponRepository;

class PromoCoupon
{
    /** @var PromoCouponRepository $promoCouponRepository */
    private $promoCouponRepository;

    /** @var PersonPointsRepository $personPointsRepository */
    private $personPointsRepository;

    public function __construct(PromoCouponRepository $promoCouponRepository, PersonPointsRepository $personPointsRepository)
    {
        $this->promoCouponRepository = $promoCouponRepository;
        $this->personPointsRepository = $personPointsRepository;
    }

    /**
     * @return PromoCouponRepository
     */
    public function getPromoCouponRepository()
    {
        return $this->promoCouponRepository;
    }

    /**
     * Проверяет, есть ли промо-код в базе с таким номером
     *
     * @param string $number
     * @return bool
     */
    public function isValidNumber(string $number)
    {
        $promoCoupon = $this->getPromoCouponRepository()->findCouponByCode($number);
        if (null === $promoCoupon) {
            return false;
        }
        return true;
    }

    /**
     * Проверяет, был ли промо-код зарегистрирован ранее
     *
     * @param string $number
     * @return bool
     */
    public function isPromoCouponRegistered(string $number)
    {
        /** @var \Zenomania\CoreBundle\Entity\PromoCoupon $promoCoupon */
        $promoCoupon = $this->getPromoCouponRepository()->findCouponByCode($number);
        if (null === $promoCoupon) {
            return false;
        }

        return $promoCoupon->getActivated();
    }

    /**
     * Активация промо-кода пользователем
     *
     * @param string $number
     * @param User $user
     * @return int
     */
    public function activateByNumber(string $number, User $user)
    {
        /** @var \Zenomania\CoreBundle\Entity\PromoCoupon $promoCoupon */
        $promoCoupon = $this->getPromoCouponRepository()->findCouponByCode($number);
        $this->activate($promoCoupon, $user);
        $points = $promoCoupon->getPoints();
        $this->getPersonPointsRepository()->givePointsForPromoCouponRegistration($user, $points);

        return $points;
    }

    /**
     * Activates promo coupon
     *
     * @param \Zenomania\CoreBundle\Entity\PromoCoupon $promoCoupon
     * @param User $user
     */
    protected function activate(\Zenomania\CoreBundle\Entity\PromoCoupon $promoCoupon, User $user)
    {
        $promoCoupon->setActivatedBy($user);
        $promoCoupon->setUpdatedOn(new \DateTime());
        $this->getPromoCouponRepository()->save($promoCoupon);
    }

    /**
     * @return PersonPointsRepository
     */
    public function getPersonPointsRepository()
    {
        return $this->personPointsRepository;
    }
}