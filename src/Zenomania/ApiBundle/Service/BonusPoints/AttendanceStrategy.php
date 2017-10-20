<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 19.10.2017
 * Time: 14:37
 */

namespace Zenomania\ApiBundle\Service\BonusPoints;

use Zenomania\CoreBundle\Entity\PersonPoints;
use Zenomania\CoreBundle\Repository\PersonPointsRepository;
use Zenomania\CoreBundle\Repository\PointsTypeRepository;

class AttendanceStrategy
{
    /**
     * @var PointsTypeRepository
     */
    private $repository;

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
        return new SubscriptionAttendance($this->getRepository());
    }
}