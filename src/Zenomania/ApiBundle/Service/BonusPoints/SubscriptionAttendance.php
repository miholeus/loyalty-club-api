<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 19.10.2017
 * Time: 12:46
 */

namespace Zenomania\ApiBundle\Service\BonusPoints;


use Zenomania\CoreBundle\Entity\PersonPoints;

class SubscriptionAttendance extends AbstractAttendance implements AttendanceInterface
{
    public function getPointsType()
    {
        return PersonPoints::TYPE_SUBSCRIPTION_ATTENDANCE;
    }
}