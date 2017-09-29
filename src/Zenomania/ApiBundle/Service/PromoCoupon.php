<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 29.09.2017
 * Time: 17:42
 */

namespace Zenomania\ApiBundle\Service;


use Zenomania\CoreBundle\Repository\PromoCouponRepository;

class PromoCoupon
{

    private $promoCouponRepository;

    public function __construct(PromoCouponRepository $promoCouponRepository)
    {
        $this->promoCouponRepository = $promoCouponRepository;
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
        return true;
    }
}