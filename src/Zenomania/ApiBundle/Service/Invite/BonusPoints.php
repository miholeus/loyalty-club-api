<?php
/**
 * @package    Zenomania\ApiBundle\Service\Invite
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service\Invite;

use Zenomania\ApiBundle\Service\PersonPoints;
use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Entity\UserReferralCode;
use Zenomania\CoreBundle\Repository\PersonPointsRepository;
use Zenomania\CoreBundle\Repository\UserReferralCodeRepository;

class BonusPoints
{
    /**
     * @var UserReferralCodeRepository
     */
    private $referralCodeRepository;
    /**
     * @var PersonPointsRepository
     */
    private $personPointsRepository;

    public function __construct(
        UserReferralCodeRepository $referralCodeRepository,
        PersonPointsRepository $personPointsRepository
    ) {
        $this->referralCodeRepository = $referralCodeRepository;
        $this->personPointsRepository = $personPointsRepository;
    }

    /**
     * Finds user by referral code
     *
     * @param string $code
     * @return UserReferralCode
     */
    public function getReferralCode(string $code)
    {
        $referralCode = $this->getReferralCodeRepository()->findByReferralCode($code);
        if (null === $referralCode) {
            throw new \InvalidArgumentException(sprintf("User by referral code %s not found", $code));
        }
        return $referralCode;
    }

    /**
     * Начисляем пользователю баллы лояльности за регистрацию по реферальному коду
     *
     * @param UserReferralCode $referralCode реферальный код при регистрации
     * @param User $user пользователь который воспользовался кодом при регистрации
     * @return int
     */
    public function givePointsForInvite(UserReferralCode $referralCode, User $user)
    {
        $this->getPersonPointsRepository()->givePointsForInvite($referralCode, $user, PersonPoints::POINTS_FOR_INVITE);

        return PersonPoints::POINTS_FOR_INVITE;
    }

    /**
     * Gets referral code
     * If code does not exist, then new one will be created
     *
     * @param User $user
     * @return string
     */
    public function getCodeForUser(User $user): string
    {
        $userReferralCode = $this->getReferralCodeRepository()->findByUser($user);

        if (null === $userReferralCode) {
            $code = $user->generateCode();

            $params = [
                'user' => $user,
                'refCode' => $code,
                'activated' => false,
                'activations' => 0,
                'dateCreated' => new \DateTime(),
                'dateUpdated' => new \DateTime()
            ];

            $userReferralCode = UserReferralCode::fromArray($params);
            $this->getReferralCodeRepository()->save($userReferralCode);
        } else {
            /** @var UserReferralCode $userReferralCode */
            $code = $userReferralCode->getRefCode();
        }

        return $code;
    }
    /**
     * @return UserReferralCodeRepository
     */
    public function getReferralCodeRepository(): UserReferralCodeRepository
    {
        return $this->referralCodeRepository;
    }

    /**
     * @return PersonPointsRepository
     */
    public function getPersonPointsRepository(): PersonPointsRepository
    {
        return $this->personPointsRepository;
    }
}