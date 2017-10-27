<?php
/**
 * Created by PhpStorm.
 * User: igorvolkov
 * Date: 27.10.17
 * Time: 12:28
 */

namespace Zenomania\ApiBundle\Service;


use Zenomania\ApiBundle\Request\Filter\BadgeFilter;
use Zenomania\ApiBundle\Service\Utils\PeriodConverter;
use Zenomania\CoreBundle\Repository\UserBadgeRepository;

class Badge
{
    /**
     * @var UserBadgeRepository
     */
    protected $badgeRepository;

    public function __construct(UserBadgeRepository $badgeRepository)
    {
        $this->badgeRepository = $badgeRepository;
    }

    public function getBadges(BadgeFilter $filter)
    {
        $date = null;
        if (null !== $filter->period) {
            $periodConverter = new PeriodConverter($filter->period);
            $date = $periodConverter->getStartDate();
            $filter->period = $date->format("Y-m-d");
        }
        return $this->getBadgeRepository()->getBadgesByFilter($filter);
    }

    /**
     * @return UserBadgeRepository
     */
    public function getBadgeRepository(): UserBadgeRepository
    {
        return $this->badgeRepository;
    }
}