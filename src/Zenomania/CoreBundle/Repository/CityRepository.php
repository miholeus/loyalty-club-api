<?php
/**
 * Created by PhpStorm.
 * User: igorvolkov
 * Date: 18.09.17
 * Time: 11:37
 */

namespace Zenomania\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CityRepository extends EntityRepository
{

    /**
     * Находит город по его id
     *
     * @param $id
     * @return mixed
     */
    public function findCityById($id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('c')
            ->from('ZenomaniaCoreBundle:City', 'c')
            ->where('c.id = :id')
            ->setParameter('id', $id)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

}