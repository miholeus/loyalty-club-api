<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 27.09.2017
 * Time: 15:16
 */

namespace Zenomania\CoreBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Zenomania\CoreBundle\Doctrine\CustomPaginator;
use Zenomania\CoreBundle\Entity\PromoCoupon;
use Zenomania\CoreBundle\Entity\User;

class PromoCouponRepository extends EntityRepository
{

    public function save(PromoCoupon $promoCoupon, User $user)
    {
        if (null === $promoCoupon->getId()) {
            $promoCoupon->setCreatedBy($user);
        }

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

    /**
     * Gets paginator
     *
     * @param string|null $str
     * @return CustomPaginator
     */
    public function getPaginator($str = null)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('pc')
            ->from('ZenomaniaCoreBundle:PromoCoupon', 'pc');

        if (!empty($query)) {
            $str = mb_strtolower(trim($str), 'utf-8');
            $query
                ->andWhere("LOWER(pc.code) LIKE :code")
                ->setParameter('code', "%{$str}%");
        }
        $paginator = new CustomPaginator($query);
        return $paginator;
    }
}