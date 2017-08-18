<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 15.08.2017
 * Time: 12:12
 */

namespace Zenomania\ApiBundle\Service;

use Zenomania\CoreBundle\Entity\EventAttendance;
use Zenomania\CoreBundle\Entity\PersonPoints;
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
    public function chargePointForTicketRegistration($user)
    {
        $charge = 200; // Сколько начислить баллов за регистрацию билета
        $season = null; // В данный момент season_id берётся из promo_action

        /**
         * @todo создать в таблице Person связь с таблицей User, прописать всё в
         * настройках orm.yml, создать миграции
         */
        $user = null;

        $params = [
            'season' => $season,
            'person' => $user,
            'points' => $charge,
            'type' => 'ticket_register',
            'state' => 'none',
            'dt' => new \DateTime()
        ];

        $personPoints = PersonPoints::fromArray($params);
        $this->getPersonPointsRepository()->save($personPoints);

        return $charge;
    }

    /**
     * Регистрация билета определенным пользователем
     *
     * @param User $user
     * @param string $barcode
     * @return EventAttendance|null
     */
    public function ticketRegistration(User $user, $barcode)
    {
        $ticket = $this->getTicketRepository()->findTicketByBarcode($barcode);
        $attendance = $this->getTicketRepository()->findAttendanceByBarcode($barcode);

        $user = null;

        $params = [
            'event' => $attendance->getEvent(),
            'person' => $user,
            'ticketId' => $ticket->getId(),
            'enterDate' => $attendance->getEnterDt()
        ];

        $eventAttendance = EventAttendance::fromArray($params);
        return $this->getEventAttendanceRepository()->save($eventAttendance);
    }

    /**
     * Проверяет, есть ли билет по указанному номеру
     *
     * @param string $barcode
     * @return bool
     */
    public function isValidBarcode($barcode)
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
    public function isTicketRegistered($barcode)
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