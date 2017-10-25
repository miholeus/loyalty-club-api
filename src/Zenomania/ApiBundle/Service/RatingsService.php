<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 25.09.17
 * Time: 16:04
 */

namespace Zenomania\ApiBundle\Service;

use Zenomania\ApiBundle\Request\Filter\RatingsFilter;
use Zenomania\ApiBundle\Service\Utils\PeriodConverter;
use Zenomania\CoreBundle\Repository\PersonPointsRepository;

class RatingsService
{
    /**
     * @var PersonPointsRepository
     */
    protected $personPointsRepository;

    public function __construct(PersonPointsRepository $personPointsRepository)
    {
        $this->personPointsRepository = $personPointsRepository;
    }

    /**
     * Fetches ratings by filter
     *
     * @param RatingsFilter $filter
     * @return array
     */
    public function getRatings(RatingsFilter $filter)
    {
        $date = null;
        if (null !== $filter->period) {
            $periodConverter = new PeriodConverter(PeriodConverter::SEASON);
            $date = $periodConverter->getStartDate();
        }

        $filter->period = $date->format("Y-m-d");
        return $this->getPersonPointsRepositry()->getRatings($filter);
    }

    /**
     * @return PersonPointsRepository
     */
    public function getPersonPointsRepositry()
    {
        return $this->personPointsRepository;
    }
}