<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 15.08.2017
 * Time: 12:12
 */

namespace Zenomania\ApiBundle\Service;


use Zenomania\CoreBundle\Repository\TicketRepository;

class Tickets
{
    /**
     * @var TicketRepository
     */
    private $ticketRepository;

    /*public function __construct(TicketRepository $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }*/

    /**
     * @return TicketRepository
     */
    public function getTicketRepository()
    {
        return $this->ticketRepository;
    }


    public function chargePointForTicketRegistration($barcode)
    {
        $charge = 100; //Сколько начислить баллов за регистрацию билета

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
        /*$ticket = $this->getTicketRepository()->findOneBy(['ticket_number' => $barcode]);
        if (null === $ticket) {
            return false;
        }*/
        return true;
    }
}