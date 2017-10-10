<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 24.08.2017
 * Time: 13:36
 */

namespace Zenomania\ApiBundle\Service;


use Zenomania\ApiBundle\Service\Exception\EntityNotFoundException;
use Zenomania\CoreBundle\Entity\Subscription;
use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Form\Model\SubscriptionNumber;
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
     * @param SubscriptionNumber $subNumber
     * @return bool
     */
    public function isValidCardcode(SubscriptionNumber $subNumber)
    {
        $subs = $this->getSubscriptionRepository()->findSubsByNumber($subNumber);

        if (null === $subs) {
            return false;
        }
        return true;
    }

    /**
     * Проверяет, был ли зарегистрирован абонемент ранее
     *
     * @param SubscriptionNumber $subNumber
     * @return bool
     */
    public function isSubscriptionRegistered(SubscriptionNumber $subNumber)
    {
        $subs = $this->getSubscriptionRepository()->findSubsByNumber($subNumber);

        if (null === $subs || null === $subs->getPerson()) {
            return false;
        }
        return true;
    }

    /**
     * Начисляем пользователю User баллы лояльности за регистрацию билета barcode
     *
     * @param User $user
     * @param Subscription $subs
     * @return int
     */
    protected function givePointsForRegistration(User $user, Subscription $subs)
    {
        $charge = round($subs->getPrice() * PersonPoints::PERCENT_FOR_SUBSCRIPTION_REGISTRATION / 100); // Сколько начислить баллов за регистрацию билета
        $this->getPersonPointsRepository()->givePointsForSubscriptionRegistration($user, $charge);
        return $charge;
    }

    /**
     * Регистрация абонемента определенным пользователем
     *
     * @param SubscriptionNumber $subNumber
     * @param User $user
     * @return int number of points for action
     * @throws EntityNotFoundException
     */
    public function subsRegistration(SubscriptionNumber $subNumber, User $user)
    {
        $subs = $this->getSubscriptionRepository()->findSubsByNumber($subNumber);
        if (null === $subs) {
            throw new EntityNotFoundException("Subscription not found by cardcode");
        }

        $person = $user->getPerson();
        $subs->setPerson($person);

        $this->getSubscriptionRepository()->save($subs);

        return $this->givePointsForRegistration($user, $subs);
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