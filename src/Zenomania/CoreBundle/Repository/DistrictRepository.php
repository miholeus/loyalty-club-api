<?php
/**
 * Created by PhpStorm.
 * User: igorvolkov
 * Date: 18.09.17
 * Time: 14:56
 */

namespace Zenomania\CoreBundle\Repository;


use Doctrine\ORM\EntityRepository;

class DistrictRepository extends EntityRepository
{
    /**
     * Находит район по его id
     *
     * @param $id
     * @return mixed
     */
    public function findDistrictById($id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('d')
            ->from('ZenomaniaCoreBundle:District', 'd')
            ->where('d.id = :id')
            ->setParameter('id', $id)
            ->getQuery();

        return $query->getOneOrNullResult();
    }
}