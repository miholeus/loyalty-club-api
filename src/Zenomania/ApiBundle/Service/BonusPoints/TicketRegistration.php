<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 18.10.2017
 * Time: 16:49
 */

namespace Zenomania\ApiBundle\Service\BonusPoints;


use Zenomania\CoreBundle\Entity\PersonPoints;

class TicketRegistration extends AbstractAttendance implements AttendanceInterface
{

    function getTypeAttendance()
    {
        return PersonPoints::TYPE_TICKET_REGISTER;
    }
}