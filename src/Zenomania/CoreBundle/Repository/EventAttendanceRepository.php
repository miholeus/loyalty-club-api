<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 18.08.2017
 * Time: 14:58
 */

namespace Zenomania\CoreBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Zenomania\CoreBundle\Entity\EventAttendance;

class EventAttendanceRepository extends EntityRepository
{
    public function save(EventAttendance $personPoints)
    {
        $this->_em->persist($personPoints);
        $this->_em->flush();
    }
}