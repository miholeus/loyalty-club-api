<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 24.08.2017
 * Time: 13:36
 */

namespace Zenomania\ApiBundle\Service;


use Zenomania\CoreBundle\Entity\Person;
use Zenomania\CoreBundle\Entity\PersonPoints;
use Zenomania\CoreBundle\Entity\PromoAction;
use Zenomania\CoreBundle\Entity\Subscription;
use Zenomania\CoreBundle\Repository\PersonPointsRepository;
use Zenomania\CoreBundle\Repository\SubscriptionRepository;

class Subscriptions
{
    /** @var PersonPointsRepository */
    private $personPointsRepository;

    /** @var SubscriptionRepository */
    private $subscriptionRepository;

    public function __construct(PersonPointsRepository $personPointsRepository, SubscriptionRepository $subscriptionRepository)
    {
        $this->personPointsRepository = $personPointsRepository;
        $this->subscriptionRepository = $subscriptionRepository;
    }

    /**
     * Проверяет, есть ли абонемент с указанным номером, сектором, рядом и местом
     *
     * @param string $cardcode
     * @param string $sector
     * @param string $row
     * @param string $seat
     * @return bool
     */
    public function isValidCardcode(string $cardcode, string $sector, string $row, string $seat)
    {
        $subs = $this->getSubscriptionRepository()->findSubsByNumber($cardcode, $sector, $row, $seat);

        if (null === $subs) {
            return false;
        }
        return true;
    }

    /**
     * Проверяет, был ли зарегистрирован абонемент ранее
     *
     * @param string $cardcode
     * @param string $sector
     * @param string $row
     * @param string $seat
     * @return bool
     */
    public function isSubscriptionRegistered(string $cardcode, string $sector, string $row, string $seat)
    {
        $subs = $this->getSubscriptionRepository()->findSubsByNumber($cardcode, $sector, $row, $seat);

        if (null === $subs || null === $subs->getPerson()) {
            return false;
        }
        return true;
    }

    /**
     * Начисляем пользователю User баллы лояльности за регистрацию билета barcode
     *
     * @param Person $person
     * @param PromoAction $promoAction
     * @return int
     */
    public function chargePointForSubsRegistration(Person $person, PromoAction $promoAction)
    {
        $charge = 3000; // Сколько начислить баллов за регистрацию билета

        $params = [
            'season' => $promoAction,
            'person' => $person,
            'points' => $charge,
            'type' => 'sub_register',
            'state' => 'none',
            'dt' => new \DateTime()
        ];

        $personPoints = PersonPoints::fromArray($params);
        $this->getPersonPointsRepository()->save($personPoints);

        return $charge;
    }

    /**
     * Регистрация абонемента определенным пользователем
     *
     * @param Person $person
     * @param string $cardcode
     * @param string $sector
     * @param string $row
     * @param string $seat
     * @return null|Subscription
     */
    public function subsRegistration(Person $person, string $cardcode, string $sector, string $row, string $seat)
    {
        $subs = $this->getSubscriptionRepository()->findSubsByNumber($cardcode, $sector, $row, $seat);
        $subs->setPerson($person);

        return $this->getSubscriptionRepository()->save($subs);
    }

    /**
     * @return PersonPointsRepository
     */
    public function getPersonPointsRepository(): PersonPointsRepository
    {
        return $this->personPointsRepository;
    }

    /**
     * @return SubscriptionRepository
     */
    public function getSubscriptionRepository(): SubscriptionRepository
    {
        return $this->subscriptionRepository;
    }
}