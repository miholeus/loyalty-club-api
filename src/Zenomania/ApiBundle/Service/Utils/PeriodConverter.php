<?php
/**
 * @package    Zenomania\ApiBundle\Service\Utils
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service\Utils;

use Zenomania\ApiBundle\Service\Exception;

class PeriodConverter
{
    const WEEK = "week";
    const MONTH = "month";
    const QUARTER = "quarter";
    const YEAR = 'year';
    const THIS_WEEK = "thisweek";

    const LAST_INTERVAL = 'last_interval';
    const NEXT_INTERVAL = 'next_interval';

    /**
     * @var array
     */
    private $intervalDays = [
        self::WEEK => 7,
        self::MONTH => 30,
        self::QUARTER => 90,
        self::YEAR => 365
    ];

    /**
     * @var \DateTime
     */
    private $startDate;

    /**
     * @var \DateTime
     */
    private $finishDate;

    /**
     * PeriodConverter constructor.
     * @param string $period
     * @param array $params
     * @throws Exception
     */
    public function __construct($period, $params = [])
    {
        if (!in_array($period, [self::WEEK, self::MONTH, self::QUARTER, self::YEAR, self::THIS_WEEK, self::LAST_INTERVAL, self::NEXT_INTERVAL])) {
            throw new Exception("Period marker not found!", 404);
        }

        switch ($period) {
            case self::WEEK:
                $this->fillByWeek();
                break;
            case self::MONTH:
                $this->fillByMonth();
                break;
            case self::QUARTER:
                $this->fillByQuarter();
                break;
            case self::YEAR:
                $this->fillByYear();
                break;
            case self::THIS_WEEK:
                $this->fillByThisWeek();
                break;
            case self::LAST_INTERVAL:
                $this->fillPeriodLastInterval($params);
                break;
            case self::NEXT_INTERVAL:
                $this->fillPeriodNextInterval($params);
                break;
            default:
                throw new Exception("Period marker not found!", 404);
        }
    }

    /**
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @return \DateTime
     */
    public function getFinishDate()
    {
        return $this->finishDate;
    }

    /**
     *  Неделя (с 00 часов понедельника до 23.59 воскресения недели, предшествующей текущей)
     */
    protected function fillByWeek()
    {
        $currentDate = new \DateTime();
        $weekForStartDate = $currentDate->modify('-1 week');
        $weekForFinishDate = clone($weekForStartDate);
        $weekForStartDate->modify('monday this week');
        $this->startDate = $weekForStartDate;
        $weekForFinishDate->modify('monday next week');
        $weekForFinishDate->modify('-1 second');
        $this->finishDate = $weekForFinishDate;
    }

    /**
     * Текущая неделя
     */
    protected function fillByThisWeek(){
        $weekForStartDate = new \DateTime();
        $weekForFinishDate = new \DateTime();
        $weekForStartDate->modify('monday this week');
        $weekForFinishDate->modify('sunday this week');
        $this->startDate = $weekForStartDate;
        $this->finishDate = $weekForFinishDate;
    }

    /**
     * Месяц (с 00 часов 1 числа до текущей даты текущего месяца)
     */
    protected function fillByMonth()
    {
        $monthForStartDate = new \DateTime();
        $monthForFinishDate = new \DateTime();
        $monthForStartDate->modify('first day of this month');
        $this->startDate = new \DateTime($monthForStartDate->format('Y-m-d 00:00:00'));
        $this->finishDate = $monthForFinishDate;
    }

    /**
     *  Квартал (с 00 1 дня до текущей даты текущего квартала)
     */
    protected function fillByQuarter()
    {
        $currentDate = new \DateTime();
        $currentQuarterNumber = intval((($currentDate->format('m') - 1) / 3) + 1);
        $firstQuarterMonthNumber = $currentQuarterNumber * 3 - 2;
        $firstQuarterMonthNumberString = $firstQuarterMonthNumber >= 10 ? $firstQuarterMonthNumber : '0' . $firstQuarterMonthNumber;
        $this->startDate = new \DateTime($currentDate->format('Y') . '-' . $firstQuarterMonthNumberString . '-01');
        $this->finishDate = $currentDate;
    }
    /**
     *  Год (с 00 1 дня до текущей даты текущего года)
     */
    protected function fillByYear()
    {
        $monthForStartDate = new \DateTime();
        $monthForFinishDate = new \DateTime();
        $monthForStartDate->modify('first day of this year');
        $this->startDate = new \DateTime($monthForStartDate->format('Y-m-d 00:00:00'));
        $this->finishDate = $monthForFinishDate;
    }

    /**
     * @param array $params
     * @throws Exception
     */
    protected function fillPeriodLastInterval($params)
    {
        if(!isset($params['interval']) || !array_key_exists($params['interval'], $this->intervalDays)){
            throw new Exception("Interval not found!", 404);
        }
        $interval = $params['interval'];
        $daysCount = $this->intervalDays[$interval] - 1;
        $dateInterval = new \DateInterval("P{$daysCount}D");

        $startDate = new \DateTime();
        $finishDate = new \DateTime();
        $this->startDate = new \DateTime($startDate->sub($dateInterval)->format('Y-m-d 00:00:00'));
        $this->finishDate = new \DateTime($finishDate->format('Y-m-d 23:59:59'));
    }

    /**
     * @param array $params
     * @throws Exception
     */
    protected function fillPeriodNextInterval($params)
    {
        if(!isset($params['interval']) || !array_key_exists($params['interval'], $this->intervalDays)){
            throw new Exception("Interval not found!", 404);
        }
        $interval = $params['interval'];
        $daysCount = $this->intervalDays[$interval] - 1;
        $dateInterval = new \DateInterval("P{$daysCount}D");

        $startDate = new \DateTime();
        $finishDate = new \DateTime();
        $this->startDate = new \DateTime($startDate->format('Y-m-d 00:00:00'));
        $this->finishDate = new \DateTime($finishDate->add($dateInterval)->format('Y-m-d 23:59:59'));
    }
}
