<?php
/**
 * @package    Zenomania\CoreBundle\Event\Listener
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\CoreBundle\Event\Listener;

use Zenomania\ApiBundle\Service\BonusPoints\TicketRegistration;
use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Event\Ticket\RegistrationEvent;

class TicketListener
{
    /**
     * @var TicketRegistration
     */
    protected $service;

    public function __construct(TicketRegistration $service)
    {
        $this->service = $service;
    }

    /**
     * User registration event
     *
     * @param RegistrationEvent $registrationEvent
     */
    public function onRegistrationEvent(RegistrationEvent $registrationEvent)
    {
        $attendance = $registrationEvent->getArgument('attendance');
        $user = $registrationEvent->getArgument('user');

        $points = $this->getService()->getPoints($attendance, $registrationEvent->getSubject());

        if (!empty($points)) {
            $this->givePointForRegistration($user, $points);
            $registrationEvent->setArgument('points', $points);
        }
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
        $this->getService()->givePointsForTicketRegistration($user, $points);

        return $points;
    }
    /**
     * @return TicketRegistration
     */
    public function getService(): TicketRegistration
    {
        return $this->service;
    }
}