<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 12.09.17
 * Time: 16:00
 */

namespace Zenomania\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Zenomania\CoreBundle\Entity\SocialAccount;

class SocialAccountRepository extends EntityRepository
{
    /**
     * Finds account by external id
     *
     * @param SocialAccount $socialAccount
     * @return SocialAccount|null
     */
    public function findAccountByOuterId(SocialAccount $socialAccount)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('sa')
            ->from('ZenomaniaCoreBundle:SocialAccount', 'sa')
            ->where('sa.outerId = :outerId')
            ->andWhere('sa.network = :network')
            ->setParameter('outerId', $socialAccount->getOuterId())
            ->setParameter('network', $socialAccount->getNetwork())
            ->getQuery();
        return $query->getOneOrNullResult();
    }

    public function isNewSocialAccount($socialName, $id)
    {
        if (empty($id)) {
            return false;
        }

        if (!empty($this->findOneBy(['network' => $socialName, 'outerId' => $id]))) {
            return false;
        }

        return true;
    }

    /**
     * Saves social account
     *
     * @param SocialAccount $socialAccount
     */
    public function save(SocialAccount $socialAccount)
    {
        $this->_em->persist($socialAccount);
        $this->_em->flush();
    }
}