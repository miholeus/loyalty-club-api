<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 19.10.2017
 * Time: 13:39
 */

namespace Zenomania\ApiBundle\Service\BonusPoints;

use Zenomania\CoreBundle\Entity\EventAttendanceImport;
use Zenomania\CoreBundle\Entity\PointsType;
use Zenomania\CoreBundle\Repository\PointsTypeRepository;

abstract class AbstractAttendance
{
    /**
     * @var PointsTypeRepository
     */
    private $repository;

    public function __construct(PointsTypeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return PointsTypeRepository
     */
    public function getRepository(): PointsTypeRepository
    {
        return $this->repository;
    }

    /**
     * Вычисляет количество очков в зависимости от времени прохода на матч
     *
     * @param EventAttendanceImport $attendance
     * @return int
     */
    public function getPoints(EventAttendanceImport $attendance): int
    {
        /** Вычисляем время до начала мероприятия, за которое болельщик пришел на стадион */
        $interval = $this->getInterval($attendance);

        /** Получаем количество процентов для начисления баллов и итогое кол-во баллов */
        /** @var PointsType $pointsType */
        $pointsType = $this->getRepository()->findPercentByTypeAndInterval($this->getPointsType(), $interval);

        $points = 0;
        if (!empty($pointsType)) {

            $points = $pointsType->getValue();
            if ($pointsType->getIsPercent()) {
                $points = (int) round($attendance->getPrice() * $points / 100);
            }
        }

        return $points;
    }

    /**
     * @param EventAttendanceImport $attendance
     * @return int
     */
    public function getInterval(EventAttendanceImport $attendance): int
    {
        $timeAttendance = $attendance->getEnterDt()->getTimestamp();
        $timeEvent = $attendance->getEvent()->getDate()->getTimestamp();
        return (int) ceil(($timeEvent - $timeAttendance) / 60);
    }

    /**
     * Attendance point's type
     *
     * @return mixed
     */
    abstract function getPointsType();
}