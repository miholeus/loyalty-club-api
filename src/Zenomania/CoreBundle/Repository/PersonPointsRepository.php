<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 18.08.2017
 * Time: 13:06
 */

namespace Zenomania\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Zenomania\ApiBundle\Form\Model\Payment;
use Zenomania\ApiBundle\Request\Filter\RatingsFilter;
use Zenomania\CoreBundle\Entity\Order;
use Zenomania\CoreBundle\Entity\Person;
use Zenomania\CoreBundle\Entity\PersonPoints;
use Zenomania\CoreBundle\Entity\PersonPointsOperationType;
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
        $season = $this->_em->getRepository('ZenomaniaCoreBundle:Season')->findCurrentSeason();

        $params = [
            'season' => $season,
            'user' => $referralCode->getUser(),
            'points' => $points,
            'type' => PersonPoints::TYPE_INVITE,
            'state' => 'none',
            'dt' => new \DateTime(),
            'operation_type' => PersonPoints::OPERATION_TYPE_DEBIT
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
            'user' => $user,
            'points' => $points,
            'type' => PersonPoints::TYPE_LINKED_VK,
            'state' => 'none',
            'dt' => new \DateTime(),
            'operation_type' => PersonPoints::OPERATION_TYPE_DEBIT
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
            'user' => $user,
            'points' => $points,
            'type' => PersonPoints::TYPE_SUBSCRIPTION_REGISTER,
            'state' => 'none',
            'dt' => new \DateTime(),
            'operation_type' => PersonPoints::OPERATION_TYPE_DEBIT
        ];

        $personPoints = PersonPoints::fromArray($params);
        $this->_em->persist($personPoints);

        $this->_em->flush();
    }

    /**
     * Add points for subscription attendance
     *
     * @param User $user
     * @param $points
     */
    public function givePointsForSubscriptionAttendance(User $user, $points)
    {
        $person = $this->_em->getRepository('ZenomaniaCoreBundle:Person')->findPersonByUser($user);
        $season = $this->_em->getRepository('ZenomaniaCoreBundle:Season')->findCurrentSeason();

        $params = [
            'season' => $season,
            'person' => $person,
            'user' => $user,
            'points' => $points,
            'type' => PersonPoints::TYPE_SUBSCRIPTION_ATTENDANCE,
            'state' => 'none',
            'dt' => new \DateTime(),
            'operation_type' => PersonPoints::OPERATION_TYPE_DEBIT
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
            'user' => $user,
            'points' => $points,
            'type' => PersonPoints::TYPE_TICKET_REGISTER,
            'state' => 'none',
            'dt' => new \DateTime(),
            'operation_type' => PersonPoints::OPERATION_TYPE_DEBIT

        ];

        $personPoints = PersonPoints::fromArray($params);
        $this->_em->persist($personPoints);

        $this->_em->flush();
    }

    /**
     * Adds points for repost
     *
     * @param User $user
     * @param $points
     * @param string $state
     * @return PersonPoints
     */
    public function givePointsForRepost(User $user, $points, $state = 'new')
    {
        $person = $this->_em->getRepository('ZenomaniaCoreBundle:Person')->findPersonByUser($user);
        $season = $this->_em->getRepository('ZenomaniaCoreBundle:Season')->findCurrentSeason();

        $params = [
            'season' => $season,
            'person' => $person,
            'user' => $user,
            'points' => $points,
            'type' => PersonPoints::TYPE_REPOST,
            'state' => $state,
            'dt' => new \DateTime(),
            'operation_type' => PersonPoints::OPERATION_TYPE_DEBIT
        ];

        $personPoints = PersonPoints::fromArray($params);
        $this->_em->persist($personPoints);

        $this->_em->flush();

        return $personPoints;
    }

    /**
     * Adds points for forecast
     *
     * @param User $user
     * @param $points
     * @param $type
     */
    public function givePointsForForecast(User $user, $points, $type)
    {
        $person = $this->_em->getRepository('ZenomaniaCoreBundle:Person')->findPersonByUser($user);
        $season = $this->_em->getRepository('ZenomaniaCoreBundle:Season')->findCurrentSeason();

        $params = [
            'season' => $season,
            'person' => $person,
            'user' => $user,
            'points' => $points,
            'type' => $type,
            'state' => 'none',
            'dt' => new \DateTime(),


            'operation_type' => PersonPoints::OPERATION_TYPE_DEBIT
        ];

        $personPoints = PersonPoints::fromArray($params);
        $this->_em->persist($personPoints);

        $this->_em->flush();
    }

    /**
     * Adds points for promo-coupon registration
     *
     * @param User $user
     * @param $points
     */
    public function givePointsForPromoCouponRegistration(User $user, $points)
    {
        $person = $this->_em->getRepository('ZenomaniaCoreBundle:Person')->findPersonByUser($user);
        $season = $this->_em->getRepository('ZenomaniaCoreBundle:Season')->findCurrentSeason();

        $params = [
            'season' => $season,
            'person' => $person,
            'user' => $user,
            'points' => $points,
            'type' => PersonPoints::TYPE_PROMO_COUPON,
            'state' => 'none',
            'dt' => new \DateTime(),
            'operation_type' => PersonPoints::OPERATION_TYPE_DEBIT
        ];

        $personPoints = PersonPoints::fromArray($params);
        $this->_em->persist($personPoints);

        $this->_em->flush();
    }

    public function givePointsForCancelledOrder(Order $order)
    {
        $person = $this->_em->getRepository('ZenomaniaCoreBundle:Person')->findPersonByUser($order->getUserId());
        $season = $this->_em->getRepository('ZenomaniaCoreBundle:Season')->findCurrentSeason();
        $params = [
            'season' => $season,
            'person' => $person,
            'user' => $order->getUserId(),
            'points' => floor($order->getPrice()),
            'type' => PersonPoints::TYPE_CANCELLED_ORDER,
            'state' => 'none',
            'dt' => new \DateTime(),
            'operation_type' => PersonPoints::OPERATION_TYPE_RETURN
        ];
        $personPoints = PersonPoints::fromArray($params);

        $this->_em->persist($personPoints);

        $this->_em->flush();
    }

    public function takePointsForCreateOrder(Order $order)
    {
        $person = $this->_em->getRepository('ZenomaniaCoreBundle:Person')->findPersonByUser($order->getUserId());
        $season = $this->_em->getRepository('ZenomaniaCoreBundle:Season')->findCurrentSeason();
        $params = [
            'season' => $season,
            'person' => $person,
            'user' => $order->getUserId(),
            'points' => -1 * floor($order->getPrice()),
            'type' => PersonPoints::TYPE_CREATE_ORDER,
            'state' => 'none',
            'dt' => new \DateTime(),
            'operation_type' => PersonPoints::OPERATION_TYPE_CREDIT
        ];
        $personPoints = PersonPoints::fromArray($params);

        $this->_em->persist($personPoints);

        $this->_em->flush();
    }

    /**
     * Total user points
     *
     * @param User $user
     * @return int
     */
    public function getTotalPoints(User $user): int
    {
        $qb = $this->_em->createQueryBuilder();
        $select = $qb->select(['points' => 'SUM(p.points)'])
            ->from('ZenomaniaCoreBundle:PersonPoints', 'p')
            ->where('p.user = :user')
            ->setParameter('user', $user);
        try {
            $result = $select->getQuery()->getSingleScalarResult();
            return intval($result);
        } catch (\Doctrine\ORM\NoResultException $e) {
            return 0;
        }
    }

    /**
     * User points aggregated by type
     *
     * @param User $user
     * @param \DateTime|null $fromDate
     * @return array
     */
    public function getUserPointsByType(User $user, \DateTime $fromDate = null)
    {
        $qb = $this->_em->createQueryBuilder();
        $select = $qb->select(['points' => 'SUM(p.points)', 'type' => 'p.type'])
            ->from('ZenomaniaCoreBundle:PersonPoints', 'p')
            ->where('p.user = :user')
            ->groupBy('p.type')
            ->setParameter('user', $user);
        if (null !== $fromDate) {
            $select->andWhere('p.dt > :date')
                ->setParameter('date', $fromDate);
        }
        try {
            $result = $select->getQuery()->getArrayResult();
            $data = [];
            foreach ($result as $item) {
                $data[$item['type']] = $item[1];
            }
            return $data;
        } catch (\Doctrine\ORM\NoResultException $e) {
            return [];
        }
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
            ->andWhere('operation_type = :operation_type')
            ->groupBy('user_id');

        $qb = clone $em->getConnection()->createQueryBuilder();

        $select = $qb->select([
            'RANK() OVER(ORDER BY points desc) AS position',
            'user_id',
            'points'
        ])->from(sprintf("(%s) as s", $subQuery))
            ->where('user_id = :user')
            ->setParameter('user', $user->getId())
            ->setParameter('operation_type', PersonPoints::OPERATION_TYPE_DEBIT);
        $result = $select->execute()->fetchAll();
        if (!empty($result)) {
            return intval($result[0]['position']);
        }
        return null;
    }

    /**
     * Получаем общи рейтинг пользователей
     *
     * @param RatingsFilter $filter
     * @return array
     */
    public function getRatings(RatingsFilter $filter)
    {
        $em = $this->getEntityManager();

        $subQuery = $em->getConnection()->createQueryBuilder()
            ->select([
                'SUM (points) AS points',
                'user_id'
            ])->from($this->getClassMetadata()->getTableName(), 'p')
            ->innerJoin('p', 'users', 'u', 'p.user_id = u.id')
            ->where('points > 0')
            ->andWhere('user_id IS NOT NULL')
            ->andWhere('operation_type = :operation_type')
            ->groupBy('user_id');
        if ($filter->period) {
            $subQuery
                ->andWhere('dt > :dt');
        }

        $qb = clone $em->getConnection()->createQueryBuilder();
        $select = $qb->select([
            'RANK () OVER (ORDER BY s.points DESC, firstname) AS position',
            's.points',
            's.user_id',
            'u.avatar',
            'u.firstname',
            'u.lastname',
            'u.middlename'
        ])->from(sprintf("(%s)", $subQuery), 's')
            ->innerJoin('s', 'users', 'u', 's.user_id = u.id')
            ->orderBy('points', 'DESC');
        if ($filter->period) {
            $select->setParameter('dt', $filter->period);
        }
        $select->setParameter('operation_type', PersonPoints::OPERATION_TYPE_DEBIT);
        $select->setMaxResults($filter->getLimit());
        $select->setFirstResult($filter->getOffset());

        $result = $select->execute()->fetchAll();
        return $result;
    }

    /**
     * Получить массив person, у которых нет связи с user
     *
     * @return array
     */
    public function getNullUserId()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select(['IDENTITY(pp.person) AS person'])
            ->from('ZenomaniaCoreBundle:PersonPoints', 'pp')
            ->where('pp.user IS NULL')
            ->groupBy('pp.person')
            ->getQuery();

        return $query->getResult();
    }

    /**
     * Обновляет в таблице person_points колонку user_id для соответствующего person_id
     *
     * @param Person $person
     * @param User $user
     * @return \Doctrine\DBAL\Driver\Statement|int
     */
    public function updateUserByPerson(Person $person, User $user)
    {
        $qb = $this->getEntityManager()->getConnection()->createQueryBuilder();;
        return $qb->update('person_points')
            ->set('user_id', $user->getId())
            ->where('person_id = :personId')
            ->setParameter('personId', $person->getId())
            ->execute();
    }

    public function givePointsForOrderInternetShop(Payment $payment,User $user)
    {
        $person = $this->_em->getRepository('ZenomaniaCoreBundle:Person')->findPersonByUser($user);
        $season = $this->_em->getRepository('ZenomaniaCoreBundle:Season')->findCurrentSeason();
        $params = [
            'season' => $season,
            'person' => $person,
            'user' => $user,
            'points' => floor($payment->getAmount()/100*10),
            'type' => PersonPoints::TYPE_CREATE_ORDER_ON_INTERNET_SHOP,
            'state' => 'none',
            'dt' => new \DateTime(),
            'operation_type' => PersonPoints::OPERATION_TYPE_DEBIT
        ];
        $personPoints = PersonPoints::fromArray($params);

        $this->_em->persist($personPoints);

        $this->_em->flush();
    }
}