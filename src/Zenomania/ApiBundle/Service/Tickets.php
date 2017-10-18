<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 15.08.2017
 * Time: 12:12
 */

namespace Zenomania\ApiBundle\Service;

use Doctrine\ORM\EntityManager;
use Zenomania\ApiBundle\Service\BonusPoints\TicketRegistration;
use Zenomania\ApiBundle\Service\Exception\EntityNotFoundException;
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

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var TicketRegistration
     */
    private $ticketRegistrationService;

    public function __construct(
        EntityManager $em,
        TicketRegistration $ticketRegistration
    ) {
        $this->em = $em;
        $this->ticketRepository = $em->getRepository('ZenomaniaCoreBundle:Ticket');
        $this->personPointsRepository = $em->getRepository('ZenomaniaCoreBundle:PersonPoints');
        $this->eventAttendanceRepository = $em->getRepository('ZenomaniaCoreBundle:EventAttendance');
        $this->ticketRegistrationService = $ticketRegistration;
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
     * @param $points
     * @return int
     */
    protected function givePointForRegistration(User $user, $points)
    {
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

        $points = $this->getTicketRegistrationService()->getPoints($attendance, $ticket);

        if (!empty($points)) {
            $this->givePointForRegistration($user, $points);
        }

        return $points;
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

    /**
     * @return EntityManager
     */
    public function getEm(): EntityManager
    {
        return $this->em;
    }

    /**
     * @return TicketRegistration
     */
    public function getTicketRegistrationService(): TicketRegistration
    {
        return $this->ticketRegistrationService;
    }
}