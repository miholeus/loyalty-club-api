<?php
/**
 * @package    Zenomania\CoreBundle\Repository
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Zenomania\CoreBundle\Entity\Event;
use Zenomania\CoreBundle\Entity\EventPlayerForecast;
use Zenomania\CoreBundle\Entity\User;

class EventPlayerForecastRepository extends EntityRepository
{
    public function save(EventPlayerForecast $forecast)
    {
        $this->_em->persist($forecast);
        $this->_em->flush();
    }

    /**
     * @param Event $event
     * @param User $user
     * @return integer
     */
    public function getTotalForecastPlayers(Event $event, User $user)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select(['cnt' => 'COUNT(f.id)'])
            ->from('ZenomaniaCoreBundle:EventForecast', 'f')
            ->where('f.event = :event')
            ->andWhere('f.user = :user')
            ->setParameter('event', $event)
            ->setParameter('user', $user)
            ->getQuery();
        try {
            $result = $query->getSingleScalarResult();
            return intval($result);
        } catch (\Doctrine\ORM\NoResultException $e) {
            return 0;
        }
    }

    /**
     * Saves forecasts
     *
     * @param \Doctrine\Common\Collections\ArrayCollection $forecasts
     */
    public function saveForecasts(\Doctrine\Common\Collections\ArrayCollection $forecasts)
    {
        $em = $this->getEntityManager();
        /** @var EventPlayerForecast $forecast */
        foreach ($forecasts as $forecast) {
            $em->persist($forecast);
        }
        $em->flush();
    }
}