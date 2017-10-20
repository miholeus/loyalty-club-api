<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 15.08.2017
 * Time: 12:12
 */

namespace Zenomania\ApiBundle\Service;

use Doctrine\ORM\EntityManager;

use Zenomania\ApiBundle\Service\Exception\EntityNotFoundException;
use Zenomania\CoreBundle\Entity\EventAttendance;
use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Event\NotificationManager;
use Zenomania\CoreBundle\Event\Ticket\RegistrationEvent;
use Zenomania\CoreBundle\Repository\EventAttendanceRepository;
use Zenomania\CoreBundle\Repository\TicketRepository;
use Zenomania\CoreBundle\Service\Traits\EventsAwareTrait;

class Tickets
{
    use EventsAwareTrait;
    /**
     * @var TicketRepository
     */
    private $ticketRepository;

    /**
     * @var EventAttendanceRepository
     */
    private $eventAttendanceRepository;

    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(
        EntityManager $em,
        NotificationManager $notificationManager
    ) {
        $this->em = $em;
        $this->notificationManager = $notificationManager;
        $this->ticketRepository = $em->getRepository('ZenomaniaCoreBundle:Ticket');
        $this->eventAttendanceRepository = $em->getRepository('ZenomaniaCoreBundle:EventAttendance');
    }

    /**
     * @return TicketRepository
     */
    public function getTicketRepository()
    {
        return $this->ticketRepository;
    }

    /**
     * Регистрация билета определенным пользователем
     *
     * @param string $barcode
     * @param User $user
     * @return int
     * @throws EntityNotFoundException
     */
    public function registerByBarcode($barcode, User $user)
    {
        $ticket = $this->getTicketRepository()->findTicketByBarcode($barcode);

        if (null === $ticket) {
            throw new EntityNotFoundException("Данный билет не найден");
        }

        if (!$this->isValidBarcode($barcode)) {
            throw new EntityNotFoundException("По данному билету {$barcode} посещение мероприятия не зафиксировано.");
        }

        if ($this->isTicketRegistered($barcode)) {
            throw new EntityNotFoundException("Данный билет {$barcode} уже был зарегистрирован ранее.");
        }

        $attendance = $this->getTicketRepository()->findAttendanceByBarcode($barcode);

        $person = $user->getPerson();

        $params = [
            'event' => $attendance->getEvent(),
            'person' => $person,
            'ticketId' => $ticket->getId(),
            'enterDate' => $attendance->getEnterDt()
        ];

        $eventAttendance = EventAttendance::fromArray($params);
        $this->getEventAttendanceRepository()->save($eventAttendance);

        $eventRegistration = new RegistrationEvent($ticket);
        $eventRegistration->setArgument('user', $user);
        $eventRegistration->setArgument('attendance', $attendance);
        $this->attachEvent($eventRegistration);

        $this->updateEvents();
        return $eventRegistration->hasArgument('points') ? $eventRegistration->getArgument('points') : 0;
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
}