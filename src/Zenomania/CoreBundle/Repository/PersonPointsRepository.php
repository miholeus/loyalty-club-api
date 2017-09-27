<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 18.08.2017
 * Time: 13:06
 */

namespace Zenomania\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Zenomania\CoreBundle\Entity\PersonPoints;
use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Entity\UserReferralCode;

class PersonPointsRepository extends EntityRepository
{
    public function save(PersonPoints $personPoints)
    {
        $this->_em->persist($personPoints);
        $this->_em->flush();
    }

    /**
     * Add points for invitation
     *
     * @param UserReferralCode $referralCode
     * @param User $user
     * @param $points
     */
    public function givePointsForInvite(UserReferralCode $referralCode, User $user, $points)
    {
        $person = $this->_em->getRepository('ZenomaniaCoreBundle:Person')->findPersonByUser($referralCode->getUser());
        $season = $this->_em->getRepository('ZenomaniaCoreBundle:Season')->findCurrentSeason();

        $params = [
            'season' => $season,
            'person' => $person,
            'points' => $points,
            'type' => PersonPoints::TYPE_INVITE,
            'state' => 'none',
            'dt' => new \DateTime()
        ];

        $personPoints = PersonPoints::fromArray($params);

        $this->_em->persist($personPoints);

        $this->_em->getRepository('ZenomaniaCoreBundle:UserReferralCode')->addActivation($referralCode, $user, false);

        $this->_em->flush();
    }

    /**
     * Add points for social network binding
     *
     * @param User $user
     * @param $points
     */
    public function givePointsForSocialBind(User $user, $points)
    {
        $person = $this->_em->getRepository('ZenomaniaCoreBundle:Person')->findPersonByUser($user);
        $season = $this->_em->getRepository('ZenomaniaCoreBundle:Season')->findCurrentSeason();

        $params = [
            'season' => $season,
            'person' => $person,
            'points' => $points,
            'type' => PersonPoints::TYPE_LINKED_VK,
            'state' => 'none',
            'dt' => new \DateTime()
        ];

        $personPoints = PersonPoints::fromArray($params);

        $this->_em->persist($personPoints);
        $this->_em->flush();
    }

    /**
     * Add points for subscription registration
     *
     * @param User $user
     * @param $points
     */
    public function givePointsForSubscriptionRegistration(User $user, $points)
    {
        $person = $this->_em->getRepository('ZenomaniaCoreBundle:Person')->findPersonByUser($user);
        $season = $this->_em->getRepository('ZenomaniaCoreBundle:Season')->findCurrentSeason();

        $params = [
            'season' => $season,
            'person' => $person,
            'points' => $points,
            'type' => PersonPoints::TYPE_SUBSCRIPTION_REGISTER,
            'state' => 'none',
            'dt' => new \DateTime()
        ];

        $personPoints = PersonPoints::fromArray($params);
        $this->_em->persist($personPoints);

        $this->_em->flush();
    }

    /**
     * Adds points for ticket registration
     *
     * @param User $user
     * @param $points
     */
    public function givePointsForTicketRegistration(User $user, $points)
    {
        $person = $this->_em->getRepository('ZenomaniaCoreBundle:Person')->findPersonByUser($user);
        $season = $this->_em->getRepository('ZenomaniaCoreBundle:Season')->findCurrentSeason();

        $params = [
            'season' => $season,
            'person' => $person,
            'points' => $points,
            'type' => PersonPoints::TYPE_TICKET_REGISTER,
            'state' => 'none',
            'dt' => new \DateTime()
        ];

        $personPoints = PersonPoints::fromArray($params);
        $this->_em->persist($personPoints);

        $this->_em->flush();
    }
    public function getTotalPoints(User $user) : int
    {
        $qb = $this->_em->createQueryBuilder();
        $select = $qb->select(['points' => 'SUM(p.points)'])
            ->from('ZenomaniaCoreBundle:PersonPoints', 'p')
            ->where('p.user = :user')
            ->setParameter('user', $user);
        $result = $select->getQuery()->getSingleScalarResult();
        return intval($result);
    }

    /**
     * Get user's rating
     *
     * @param User $user
     * @return int|null
     */
    public function getRating(User $user)
    {
        $em = $this->getEntityManager();

        $subQuery = $em->getConnection()->createQueryBuilder()
            ->select([
                'SUM(points) AS points',
                'user_id'
            ])
            ->from($this->getClassMetadata()->getTableName())
            ->where('user_id IS NOT NULL')
            ->groupBy('user_id');

        $qb = clone $em->getConnection()->createQueryBuilder();

        $select = $qb->select([
            'RANK() OVER(ORDER BY points desc) AS position',
            'user_id',
            'points'
        ])->from(sprintf("(%s) as s", $subQuery))
            ->where('user_id = :user')
            ->setParameter('user', $user->getId());
        $result = $select->execute()->fetchAll();
        if (!empty($result)) {
            return intval($result[0]['position']);
        }
        return null;
    }
}