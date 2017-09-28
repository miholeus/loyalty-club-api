<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 25.09.17
 * Time: 16:04
 */

namespace Zenomania\ApiBundle\Service;

use Zenomania\ApiBundle\Request\Filter\RatingsFilter;
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

    public function getRatings(RatingsFilter $filter)
    {
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