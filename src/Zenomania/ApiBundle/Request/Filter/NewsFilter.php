<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 30.10.17
 * Time: 11:35
 */

namespace Zenomania\ApiBundle\Request\Filter;


class NewsFilter extends AbstractFilter
{
    /**
     * @var int
     */
    protected $offset = 0;

    /**
     * @var int
     */
    protected $limit = 5;
}