<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 27.09.2017
 * Time: 15:16
 */

namespace Zenomania\CoreBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Zenomania\CoreBundle\Entity\PromoCoupon;

class PromoCouponRepository extends EntityRepository
{
    public function save(PromoCoupon $promoCoupon)
    {
        $this->_em->persist($promoCoupon);
        $this->_em->flush();
    }

    /**
     * @param string $code
     * @return mixed
     */
    public function findCouponByCode(string $code)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('pc')
            ->from('ZenomaniaCoreBundle:PromoCoupon', 'pc')
            ->where('pc.code = :code')
            ->setParameter('code', $code)
            ->getQuery();

        return $query->getOneOrNullResult();
    }
}