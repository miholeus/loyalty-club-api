<?php

namespace Zenomania\CoreBundle\Repository;

use Zenomania\CoreBundle\Entity\UserBadge;

/**
 * UserBadgeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserBadgeRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param UserBadge $userBadge
     */
    public function save(UserBadge $userBadge)
    {
        $this->_em->persist($userBadge);
        $this->_em->flush();
    }

    /**
     * @param UserBadge $userBadge
     */
    public function remove(UserBadge $userBadge)
    {
        $this->_em->remove($userBadge);
        $this->_em->flush();
    }
}
