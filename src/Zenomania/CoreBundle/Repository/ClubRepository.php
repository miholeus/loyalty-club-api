<?php
/**
 * @package    Zenomania\CoreBundle\Repository
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Zenomania\CoreBundle\Doctrine\CustomPaginator;
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
}