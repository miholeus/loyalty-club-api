<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 25.09.17
 * Time: 18:37
 */

namespace Zenomania\ApiBundle\Form\Model;


class Ratings
{
    /**
     * @var integer
     */
    private $limit;

    /**
     * @var integer
     */
    private $offset;

    /**
     * @var string
     */
    private $period;

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     */
    public function setLimit(int $limit)
    {
        $this->limit = $limit;
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @param int $offset
     */
    public function setOffset(int $offset)
    {
        $this->offset = $offset;
    }

    /**
     * @return string
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * @param string $period
     */
    public function setPeriod(string $period)
    {
        $this->period = $period;
    }
}