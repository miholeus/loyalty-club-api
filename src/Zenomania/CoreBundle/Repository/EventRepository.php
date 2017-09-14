<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 14.09.2017
 * Time: 15:25
 */

namespace Zenomania\CoreBundle\Repository;


use Doctrine\ORM\EntityRepository;

class EventRepository extends EntityRepository
{

    /**
     * Находит событие по его id
     *
     * @param $id
     * @return mixed
     */
    public function findEventById($id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('e')
            ->from('ZenomaniaCoreBundle:Event', 'e')
            ->where('e.id = :id')
            ->setParameter('id', $id)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    /**
     * @param $count
     * @return array
     */
    public function findLastEvents($count)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('e')
            ->from('ZenomaniaCoreBundle:Event', 'e')
            ->orderBy('e.id', 'DESC')
            ->setMaxResults($count)
            ->getQuery();

        return $query->getResult();
    }
}