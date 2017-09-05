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
     * @return mixed
     */
    public function findCodeByUser(User $user)
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
     * @param string $refcode
     * @return mixed
     */
    public function findCodeByRefcode(string $refcode)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('urc')
            ->from('ZenomaniaCoreBundle:UserReferralCode', 'urc')
            ->where('urc.refCode = :refcode')
            ->setParameter('refcode', $refcode)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    /**
     * @param UserReferralCode $userReferralCode
     * @return mixed
     */
    public function addActivations(UserReferralCode $userReferralCode)
    {
        $activations = $userReferralCode->getActivations() + 1;

        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->update('ZenomaniaCoreBundle:UserReferralCode', 'urc')
            ->set('urc.activations', ':activations')
            ->set('urc.activated', ':activated')
            ->where('urc.refCode = :refcode')
            ->setParameter('activations', $activations)
            ->setParameter('activated', true)
            ->setParameter('refcode', $userReferralCode->getRefCode())
            ->getQuery();

        return $query->execute();
    }
}