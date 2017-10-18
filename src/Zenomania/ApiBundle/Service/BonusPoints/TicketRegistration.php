<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 18.10.2017
 * Time: 16:49
 */

namespace Zenomania\ApiBundle\Service\BonusPoints;


use Zenomania\CoreBundle\Entity\EventAttendanceImport;
use Zenomania\CoreBundle\Entity\PersonPoints;
use Zenomania\CoreBundle\Entity\PointsType;
use Zenomania\CoreBundle\Entity\Ticket;
use Zenomania\CoreBundle\Repository\PointsTypeRepository;

class TicketRegistration
{

    /** @var PointsTypeRepository */
    private $pointsTypeRepository;

    public function __construct(PointsTypeRepository $pointsTypeRepository)
    {
        $this->pointsTypeRepository = $pointsTypeRepository;
    }

    /**
     * Вычисляет количество очков в зависимости от времени прохода на матч
     *
     * @param EventAttendanceImport $attendance
     * @param Ticket $ticket
     * @return float|int
     */
    public function getPoints(EventAttendanceImport $attendance, Ticket $ticket)
    {
        /** Вычисляем время до начала мероприятия, за которое болельщик пришел на стадион */
        $timeAttendance = $attendance->getEnterDt()->getTimestamp();
        $timeEvent = $ticket->getEvent()->getDate()->getTimestamp();
        $interval = intval(ceil(($timeEvent - $timeAttendance) / 60));

        /** Получаем количество процентов для начисления баллов и итогое кол-во баллов */
        /** @var PointsType $pointsType */
        $pointsType = $this->getPointsTypeRepository()->findPercentByTypeAndInterval(PersonPoints::TYPE_TICKET_REGISTER, $interval);

        $points = 0;
        if (!empty($pointsType)) {

            $points = $pointsType->getValue();
            if ($pointsType->getIsPercent()) {
                $points = round($ticket->getPrice() * $points / 100);
            }
        }

        return $points;
    }

    /**
     * @return PointsTypeRepository
     */
    public function getPointsTypeRepository(): PointsTypeRepository
    {
        return $this->pointsTypeRepository;
    }
}