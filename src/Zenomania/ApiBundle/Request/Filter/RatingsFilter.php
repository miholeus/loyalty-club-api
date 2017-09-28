<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 28.09.17
 * Time: 14:17
 */

namespace Zenomania\ApiBundle\Request\Filter;


use Zenomania\ApiBundle\Service\Utils\PeriodConverter;

class RatingsFilter
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
     * @var \DateTime
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

    /**
     * Set data from array
     *
     * @param array $data
     */
    public function setFromArray(array $data)
    {
        foreach ($data as $key => $value) {
            if ($key == 'period' && $value) {
                $period = new PeriodConverter($value);
                $value = $period->getStartDate()->format('Y-m-d');
            }
            $this->{"set" . ucfirst($key)}($value);
        }
    }
}