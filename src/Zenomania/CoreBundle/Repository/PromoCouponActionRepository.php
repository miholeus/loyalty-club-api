<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 27.09.2017
 * Time: 17:26
 */

namespace Zenomania\CoreBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Zenomania\CoreBundle\Entity\PromoCouponAction;

class PromoCouponActionRepository extends EntityRepository
{

    public function save(PromoCouponAction $pcaction)
    {
        $this->_em->persist($pcaction);
        $this->_em->flush();
    }
}