<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 05.09.2017
 * Time: 14:17
 */

namespace Zenomania\CoreBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Zenomania\CoreBundle\Entity\UserReferralActivation;

class UserReferralActivationRepository extends EntityRepository
{

    public function save(UserReferralActivation $userRefActivation)
    {
        $this->_em->persist($userRefActivation);
        $this->_em->flush();
    }
}