<?php
/**
 * @package    Zenomania\CoreBundle\Repository
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Zenomania\CoreBundle\Doctrine\CustomPaginator;
use Zenomania\CoreBundle\Entity\Club;
use Zenomania\CoreBundle\Entity\Person;
use Zenomania\CoreBundle\Entity\User;

class ClubRepository extends EntityRepository
{
    /**
     * Gets paginator
     *
     * @return CustomPaginator
     */
    public function getPaginator()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('c')
            ->from('ZenomaniaCoreBundle:Club', 'c');
        $paginator = new CustomPaginator($query);
        return $paginator;
    }

    /**
     * @param string $name
     * @param int $id
     * @return Club|null
     */
    public function findByNameAndExternalId(string $name, int $id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('c')
            ->from('ZenomaniaCoreBundle:Club', 'c')
            ->where('LOWER(c.name) = LOWER(:name)')
            ->orWhere('c.externalId = :externalId')
            ->setParameter('name', mb_strtolower($name, 'utf-8'))
            ->setParameter('externalId', $id);
        return $query->getQuery()->getOneOrNullResult();
    }

    /**
     * Saves club
     *
     * @param Club $club
     */
    public function save(Club $club)
    {
        $this->_em->persist($club);
        $this->_em->flush();
    }
}