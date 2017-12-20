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
use Zenomania\CoreBundle\Document\ProviderEvent;
use Zenomania\CoreBundle\Entity\Event;

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
     * Finds event by external identifier
     *
     * @param $id
     * @return Event|null
     */
    public function findEventByExternalId($id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('e')
            ->from('ZenomaniaCoreBundle:Event', 'e')
            ->where('e.externalId = :id')
            ->setParameter('id', $id)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    /**
     * Finds event by name and date
     *
     * @param $name
     * @param \DateTime $date
     * @return Event|null
     */
    protected function findEventByNameAndDate($name, \DateTime $date)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('e')
            ->from('ZenomaniaCoreBundle:Event', 'e')
            ->where('e.name = :name')
            ->andWhere('e.date = :date')
            ->setParameter('name', $name)
            ->setParameter('date', $date->format("Y-m-d H:i:s"))
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    /**
     * @param \DateTime $date
     * @return mixed
     */
    protected function findSeasonId(\DateTime $date)
    {
        $repo = $this->getEntityManager()->getRepository('ZenomaniaCoreBundle:Season');
        $season = $repo->findSeasonByDate($date);
        if (null !== $season) {
            return $season->getId();
        }
        return null;
    }

    /**
     * Inserts new event
     *
     * @param ProviderEvent $event
     * @return int
     */
    public function addIfNotExists(ProviderEvent $event)
    {
        if (null !== ($current = $this->findEventByExternalId($event->getEventId()))) {
            return $current->getId();
        }

        // find by name & date
        if (null !== ($current = $this->findEventByNameAndDate($event->getName(), $event->getDateStart()))) {
            // update external id
            $current->setExternalId($event->getEventId());
            $this->_em->persist($current);
            $this->_em->flush();
            return $current->getId();
        }

        $conn = $this->getEntityManager()->getConnection();
        $conn->insert($this->getEntityManager()->getClassMetadata('ZenomaniaCoreBundle:Event')->getTableName(), [
            'external_id' => $event->getEventId(),
            'name' => $event->getName(),
            'date' => $event->getDateStart()->format("Y-m-d H:i:s"),
            'club_home' => $this->findClub($event->getClubOwner()),
            'club_guest' => $this->findClub($event->getClubGuest()),
            'season_id' => $this->findSeasonId($event->getDateStart()),
            'sport_id' => 7
        ]);
        return $conn->lastInsertId('event_id_seq');
    }

    /**
     * Find club by its external id
     *
     * @param $externalId
     * @return mixed
     */
    protected function findClub($externalId)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('e')
            ->from('ZenomaniaCoreBundle:Club', 'e')
            ->where('e.externalId = :id')
            ->setParameter('id', $externalId)
            ->getQuery();

        $club = $query->getOneOrNullResult();
        if (null !== $club) {
            return $club->getId();
        }
        return null;
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