<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 14.09.2017
 * Time: 15:25
 */

namespace Zenomania\CoreBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Zenomania\CoreBundle\Doctrine\CustomPaginator;
use Zenomania\CoreBundle\Event\Event;

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
     *
     *
     * @param $limit
     * @return array
     */
    public function findLastEvents($limit)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('e')
            ->from('ZenomaniaCoreBundle:Event', 'e')
            ->orderBy('e.date', 'DESC')
            ->setMaxResults($limit)
            ->getQuery();

        return $query->getResult();
    }

    /**
     *
     *
     * @param $limit
     * @return array
     */
    public function findLastScoreSavedEvents($limit)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('e')
            ->from('ZenomaniaCoreBundle:Event', 'e')
            ->where('e.scoreSaved = :score')
            ->setParameter('score', \Zenomania\CoreBundle\Entity\Event::SCORE_SAVED_PROCESSED)
            ->orderBy('e.date', 'DESC')
            ->setMaxResults($limit)
            ->getQuery();

        return $query->getResult();
    }

    /**
     * Gets paginator
     *
     * @return CustomPaginator
     */
    public function getPaginator()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('e')
            ->from('ZenomaniaCoreBundle:Event', 'e')
            ->orderBy('e.date', 'DESC');
        $paginator = new CustomPaginator($query);
        return $paginator;
    }

    /**
     * @param \DateTimeImmutable $dt
     * @return Event|null
     */
    public function findNextEvent(\DateTimeImmutable $dt)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('e')
            ->from('ZenomaniaCoreBundle:Event', 'e')
            ->where('e.date > :date')
            ->setParameter('date', $dt)
            ->orderBy('e.date', 'ASC')
            ->setMaxResults(1);
        return $query->getQuery()->getOneOrNullResult();
    }

    /**
     * @param \Zenomania\CoreBundle\Entity\Event $event
     */
    public function save(\Zenomania\CoreBundle\Entity\Event $event)
    {
        $this->getEntityManager()->persist($event);
        $this->getEntityManager()->flush();
    }

    /**
     * @param \Zenomania\CoreBundle\Entity\Event $event
     * @return array|\Zenomania\CoreBundle\Entity\LineUp[]
     */
    public function findLineUp(\Zenomania\CoreBundle\Entity\Event $event)
    {
        $repo = $this->getEntityManager()->getRepository('ZenomaniaCoreBundle:LineUp');
        return $repo->findBy(['event' => $event]);
    }
    /**
     * Removes line up from entity manager
     *
     * @param \Zenomania\CoreBundle\Entity\LineUp $lineUp
     */
    public function removeLineUp(\Zenomania\CoreBundle\Entity\LineUp $lineUp)
    {
        $this->getEntityManager()->remove($lineUp);
    }
}