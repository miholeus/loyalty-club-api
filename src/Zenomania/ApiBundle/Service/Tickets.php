<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 15.08.2017
 * Time: 12:12
 */

namespace Zenomania\ApiBundle\Service;

use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Repository\TicketRepository;

class Tickets
{
    /**
     * @var TicketRepository
     */
    private $ticketRepository;

    public function __construct(TicketRepository $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
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
     * @param string $barcode
     * @return int
     */
    public function chargePointForTicketRegistration($user, $barcode)
    {
        $charge = 200; //Сколько начислить баллов за регистрацию билета

        /*
         * person_points
         * season_id = 11;
        person_id = 1;
        points = 100;
        type = 'ticket_register';
        state = 'none';
        dt = '2017-06-01 13:41:22';*/

        return $charge;
    }

    /**
     * Проверяет, есть ли билет по указанному номеру
     *
     * @param string $barcode
     * @return bool
     */
    public function isValidBarcode($barcode)
    {
        $ticket = $this->getTicketRepository()->findTicketByBarcode($barcode);
        if (null === $ticket) {
            return false;
        }
        return true;
    }
}