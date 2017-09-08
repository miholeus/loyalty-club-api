<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 04.09.2017
 * Time: 12:30
 */

namespace Zenomania\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Entity\UserReferralCode;

class UserReferralCodeRepository extends EntityRepository
{
    public function save(UserReferralCode $userReferralCode)
    {
        $this->_em->persist($userReferralCode);
        $this->_em->flush();
    }

    /**
     * @param User $user
     * @return UserReferralCode|null
     */
    public function findByUser(User $user)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('urc')
            ->from('ZenomaniaCoreBundle:UserReferralCode', 'urc')
            ->where('urc.user = :user')
            ->setParameter('user', $user)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    /**
     * @param string $referralCode
     * @return UserReferralCode|null
     */
    public function findByReferralCode(string $referralCode)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('urc')
            ->from('ZenomaniaCoreBundle:UserReferralCode', 'urc')
            ->where('urc.refCode = :refCode')
            ->setParameter('refCode', $referralCode)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    /**
     * @param UserReferralCode $userReferralCode
     * @return mixed
     */
    public function addActivation(UserReferralCode $userReferralCode)
    {
        $userReferralCode->addActivation();

        $this->_em->persist($userReferralCode);
        $this->_em->flush();
    }
}