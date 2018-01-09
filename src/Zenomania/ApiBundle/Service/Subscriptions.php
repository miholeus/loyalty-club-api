<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 24.08.2017
 * Time: 13:36
 */

namespace Zenomania\ApiBundle\Service;


use Zenomania\ApiBundle\Service\Exception\EntityNotFoundException;
use Zenomania\CoreBundle\Entity\EventAttendance;
use Zenomania\CoreBundle\Entity\Subscription;
use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Form\Model\SubscriptionNumber;
use Zenomania\CoreBundle\Repository\EventAttendanceRepository;
use Zenomania\CoreBundle\Repository\PersonPointsRepository;
use Zenomania\CoreBundle\Repository\SubscriptionRepository;

class Subscriptions
{
    /** @var PersonPointsRepository */
    private $personPointsRepository;

    /** @var SubscriptionRepository */
    private $subscriptionRepository;

    /**
     * @var EventAttendanceRepository
     */
    private $eventAttendanceRepository;

    public function __construct(PersonPointsRepository $personPointsRepository, SubscriptionRepository $subscriptionRepository, EventAttendanceRepository $eventAttendanceRepository)
    {
        $this->personPointsRepository = $personPointsRepository;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->eventAttendanceRepository = $eventAttendanceRepository;
    }

    /**
     * Проверяет, есть ли абонемент с указанным номером, сектором, рядом и местом
     *
     * @param Subscription $sub
     * @return bool
     */
    public function isValidCardcode(Subscription $sub)
    {
        $attendance = $this->getSubscriptionRepository()->findAttendance($sub);

        if (null === $attendance) {
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
        $attendance = $this->getSubscriptionRepository()->findSubscriptionRegistration($subNumber);

        if (null === $attendance) {
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
        $subscription = $this->getSubscriptionRepository()->findSubsByNumber($subNumber);
        if (null === $subscription) {
            throw new EntityNotFoundException("Абонемент {$subNumber->getCardcode()} не найден");
        }

        if (!$this->isValidCardcode($subscription)) {
            throw new EntityNotFoundException("По данному абонементу {$subNumber->getCardcode()} посещение мероприятия не зафиксировано.");
        }

        if ($this->isSubscriptionRegistered($subNumber)) {
            throw new EntityNotFoundException("Абонемент {$subNumber->getCardcode()} уже был зарегистрирован ранее");
        }

        $person = $user->getPerson();

        $attendance = $this->getSubscriptionRepository()->findAttendance($subscription);

        $params = [
            'event' => $attendance->getEvent(),
            'person' => $person,
            'subscriptionId' => $subscription->getId(),
            'enterDate' => $attendance->getEnterDt()
        ];

        $eventAttendance = EventAttendance::fromArray($params);

        $this->getEventAttendanceRepository()->save($eventAttendance);

        return $this->givePointsForRegistration($user, $subscription);
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

    /**
     * @return EventAttendanceRepository
     */
    public function getEventAttendanceRepository(): EventAttendanceRepository
    {
        return $this->eventAttendanceRepository;
    }
}