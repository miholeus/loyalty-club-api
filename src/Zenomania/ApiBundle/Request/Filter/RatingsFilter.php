<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 28.09.17
 * Time: 14:17
 */

namespace Zenomania\ApiBundle\Request\Filter;


class RatingsFilter extends AbstractFilter
{
    /**
     * @var string
     */
    public $period;
    /**
     * @var int
     */
    protected $limit = 20;
}