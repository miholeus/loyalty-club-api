<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 19.10.2017
 * Time: 14:37
 */

namespace Zenomania\ApiBundle\Service\BonusPoints;


use Zenomania\CoreBundle\Entity\PersonPoints;
use Zenomania\CoreBundle\Repository\PointsTypeRepository;

class AttendanceStrategy
{

    /**
     * @var PointsTypeRepository
     */
    private $repository;

    /**
     * @var AttendanceInterface
     */
    private $attendance;

    public function __construct(PointsTypeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return PointsTypeRepository
     */
    public function getRepository(): PointsTypeRepository
    {
        return $this->repository;
    }

    /**
     * @return AttendanceInterface
     */
    public function getAttendance(): AttendanceInterface
    {
        return $this->attendance;
    }

    public function setAttendance($typeAttendance)
    {
        if (PersonPoints::TYPE_SUBSCRIPTION_ATTENDANCE == $typeAttendance) {
            $this->attendance = new SubscriptionAttendance($this->getRepository());
        } elseif (PersonPoints::TYPE_TICKET_REGISTER == $typeAttendance) {
            $this->attendance = new TicketRegistration($this->getRepository());
        } else {
            throw new TypeAttendanceException('Не найден тип прохода на мероприятия');
        }
    }
}