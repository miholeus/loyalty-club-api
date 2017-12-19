<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 18.09.2017
 * Time: 12:00
 */

namespace Zenomania\CoreBundle\Repository;


use Doctrine\ORM\EntityRepository;

class ActorRepository extends EntityRepository
{

    /**
     * @return array
     */
    public function findAll()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('a')
            ->from('ZenomaniaCoreBundle:Actor', 'a')
            ->getQuery();

        return $query->getResult();
    }
}
