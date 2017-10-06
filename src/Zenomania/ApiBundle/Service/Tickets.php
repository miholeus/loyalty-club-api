<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 15.08.2017
 * Time: 12:12
 */

namespace Zenomania\ApiBundle\Service;

use Zenomania\ApiBundle\Service\Exception\EntityNotFoundException;
use Zenomania\CoreBundle\Entity\EventAttendance;
use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Repository\EventAttendanceRepository;
use Zenomania\CoreBundle\Repository\PersonPointsRepository;
use Zenomania\CoreBundle\Repository\TicketRepository;

class Tickets
{
    /**
     * @var TicketRepository
     */
    private $ticketRepository;

    /**
     * @var PersonPointsRepository
     */
    private $personPointsRepository;

    /**
     * @var EventAttendanceRepository
     */
    private $eventAttendanceRepository;

    public function __construct(
        TicketRepository $ticketRepository,
        PersonPointsRepository $personPointsRepository,
        EventAttendanceRepository $eventAttendanceRepository
    ) {
        $this->ticketRepository = $ticketRepository;
        $this->personPointsRepository = $personPointsRepository;
        $this->eventAttendanceRepository = $eventAttendanceRepository;
    }

    /**
     * @return TicketRepository
     */
    public function getTicketRepository()
    {
        return $this->ticketRepository;
    }

    /**
     * Начисляем пользователю User баллы лояльности за регистрацию билета barcode
     *
     * @param User $user
     * @return int
     */
    protected function givePointForRegistration(User $user)
    {
        $points = PersonPoints::POINTS_FOR_TICKET_REGISTRATION; // Сколько начислить баллов за регистрацию билета
        $this->getPersonPointsRepository()->givePointsForTicketRegistration($user, $points);

        return $points;
    }

    /**
     * Регистрация билета определенным пользователем
     *
     * @param string $barcode
     * @param User $user
     * @return int
     * @throws EntityNotFoundException
     */
    public function ticketRegistration($barcode, User $user)
    {
        $ticket = $this->getTicketRepository()->findTicketByBarcode($barcode);

        if (null === $ticket) {
            throw new EntityNotFoundException("Ticket not found by barcode");
        }

        $attendance = $this->getTicketRepository()->findAttendanceByBarcode($barcode);

        if (null === $attendance) {
            throw new EntityNotFoundException("Attendance not found by barcode");
        }

        $person = $user->getPerson();

        $params = [
            'event' => $attendance->getEvent(),
            'person' => $person,
            'ticketId' => $ticket->getId(),
            'enterDate' => $attendance->getEnterDt()
        ];

        $eventAttendance = EventAttendance::fromArray($params);
        $this->getEventAttendanceRepository()->save($eventAttendance);

        /** @todo Вычилисть интервал за сколько прошел болельщик на матч и передать его в функцию для начисления в соответсвии с этим интервалом очков */
        $timeAttendance = 'Получить время прохода на стадион';
        $timeEvent = 'Получить время мероприятия';
        $interval = (($timeEvent - $timeAttendance) >= 0) ?: 0;

        return $this->givePointForRegistration($user);
    }

    /**
     * Проверяет, есть ли билет по указанному номеру
     *
     * @param string $barcode
     * @return bool
     */
    public function isValidBarcode(string $barcode)
    {
        $ticket = $this->getTicketRepository()->findAttendanceByBarcode($barcode);
        if (null === $ticket) {
            return false;
        }
        return true;
    }

    /**
     * Проверяет, был ли билет зарегистрирован ранее
     *
     * @param string $barcode
     * @return bool
     */
    public function isTicketRegistered(string $barcode)
    {
        $ticket = $this->getTicketRepository()->findTicketRegistration($barcode);
        if (null === $ticket) {
            return false;
        }
        return true;
    }

    /**
     * @return PersonPointsRepository
     */
    public function getPersonPointsRepository(): PersonPointsRepository
    {
        return $this->personPointsRepository;
    }

    /**
     * @return EventAttendanceRepository
     */
    public function getEventAttendanceRepository(): EventAttendanceRepository
    {
        return $this->eventAttendanceRepository;
    }
}