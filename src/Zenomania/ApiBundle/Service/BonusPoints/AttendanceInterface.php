<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 19.10.2017
 * Time: 13:30
 */

namespace Zenomania\ApiBundle\Service\BonusPoints;


use Zenomania\CoreBundle\Entity\EventAttendanceImport;

interface AttendanceInterface
{
    /**
     * Получить интервал времени между проходом и началом мероприятия
     *
     * @param EventAttendanceImport $attendance
     * @return int
     */
    public function getInterval(EventAttendanceImport $attendance): int;

    /**
     * Получить количество очков за проход на мероприятие
     *
     * @param EventAttendanceImport $attendance
     * @return int
     */
    public function getPoints(EventAttendanceImport $attendance): int;
}