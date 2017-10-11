<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 23.08.2017
 * Time: 12:42
 */

namespace Zenomania\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Zenomania\CoreBundle\Entity\Actor;
use Zenomania\CoreBundle\Entity\Person;
use Zenomania\CoreBundle\Entity\User;

class PersonRepository extends EntityRepository
{

    /**
     * @param User $user
     * @return Person
     */
    public function findPersonByUser(User $user)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('u')
            ->from('ZenomaniaCoreBundle:Person', 'u')
            ->where('u.user = :user')
            ->setParameter('user', $user->getId())
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    /**
     * @param Actor $actor
     * @return Person
     */
    public function findPersonByActor(Actor $actor)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('u')
            ->from('ZenomaniaCoreBundle:Person', 'u')
            ->where('u.id = :actor')
            ->setParameter('actor', $actor->getPerson()->getId())
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    public function save(Person $person)
    {
        $this->_em->persist($person);
        $this->_em->flush();
    }

    public function isFullProfile(User $user)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('u')
            ->from('ZenomaniaCoreBundle:Person', 'u')
            ->where('u.user = :user')
            ->andWhere('u.firstName IS NOT NULL')
            ->andWhere('u.lastName IS NOT NULL')
            ->andWhere('u.middleName IS NOT NULL')
            ->andWhere('u.email IS NOT NULL')
            ->andWhere('u.bdate IS NOT NULL')
            ->andWhere('u.city IS NOT NULL')
            ->andWhere('u.district IS NOT NULL')
            ->setParameter('user', $user->getId())
            ->getQuery();

        return $query->getOneOrNullResult();
    }

}