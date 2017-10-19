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
use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Repository\PersonPointsRepository;
use Zenomania\CoreBundle\Repository\PointsTypeRepository;

class TicketRegistration
{

    /**
     * @var PointsTypeRepository
     */
    private $pointsTypeRepository;

    /**
     * @var PersonPointsRepository
     */
    private $personPointsRepository;

    public function __construct(PointsTypeRepository $pointsTypeRepository, PersonPointsRepository $personPointsRepository)
    {
        $this->pointsTypeRepository = $pointsTypeRepository;
        $this->personPointsRepository = $personPointsRepository;
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
     * Gives points for ticket registration to selected user
     *
     * @param User $user
     * @param $points
     */
    public function givePointsForTicketRegistration(User $user, $points)
    {
        $this->getPersonPointsRepository()->givePointsForTicketRegistration($user, $points);
    }

    /**
     * @return PointsTypeRepository
     */
    public function getPointsTypeRepository(): PointsTypeRepository
    {
        return $this->pointsTypeRepository;
    }

    /**
     * @return PersonPointsRepository
     */
    public function getPersonPointsRepository(): PersonPointsRepository
    {
        return $this->personPointsRepository;
    }
}