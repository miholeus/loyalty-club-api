<?php
/**
 * @package    Zenomania\CoreBundle\Repository
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Zenomania\CoreBundle\Entity\Event;
use Zenomania\CoreBundle\Entity\EventForecast;
use Zenomania\CoreBundle\Entity\User;

class EventForecastRepository extends EntityRepository
{
    public function save(EventForecast $forecast)
    {
        $this->_em->persist($forecast);
        $this->_em->flush();
    }

    /**
     * @param Event $event
     * @param User $user
     * @return EventForecast|null
     */
    public function getEventForecast(Event $event, User $user)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('f')
            ->from('ZenomaniaCoreBundle:EventForecast', 'f')
            ->where('f.event = :event')
            ->andWhere('f.user = :user')
            ->setParameter('event', $event)
            ->setParameter('user', $user)
            ->getQuery();
        return $query->getOneOrNullResult();
    }
}