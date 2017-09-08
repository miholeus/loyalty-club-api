<?php
/**
 * @package    Zenomania\CoreBundle\Event\Listener
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\CoreBundle\Event\Listener;

use Zenomania\ApiBundle\Service\Invite\BonusPoints;
use Zenomania\CoreBundle\Event\User\ReferralCodeAppliedEvent;

class RegistrationListener
{
    /**
     * @var BonusPoints
     */
    private $bonusPoints;

    public function __construct(BonusPoints $bonusPoints)
    {
        $this->bonusPoints = $bonusPoints;
    }

    /**
     * Apply referral code
     *
     * @param ReferralCodeAppliedEvent $event
     */
    public function onReferralCodeAppliedEvent(ReferralCodeAppliedEvent $event)
    {
        // Определяем пользователя, которому принадлежит реферальный код
        $referralCode = $this->getBonusPoints()->getReferralCode($event->getArgument('code'));

        // Подключаем сервис для приглашений
        $inviteService = $this->getBonusPoints();

        // Начисляем баллы пользователю User
        $inviteService->givePointsForInvite($referralCode, $event->getArgument('user'));
    }

    /**
     * @return BonusPoints
     */
    public function getBonusPoints(): BonusPoints
    {
        return $this->bonusPoints;
    }
}