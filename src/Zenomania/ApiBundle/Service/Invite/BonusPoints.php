<?php
/**
 * @package    Zenomania\ApiBundle\Service\Invite
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service\Invite;

use Zenomania\CoreBundle\Entity\Person;
use Zenomania\CoreBundle\Entity\PersonPoints;
use Zenomania\CoreBundle\Entity\PromoAction;
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
     * Начисляем пользователю User баллы лояльности за регистрацию по рефреальному коду
     *
     * @param Person $person
     * @param PromoAction $promoAction
     *
     * @return int
     */
    public function chargePointForInvite(Person $person, PromoAction $promoAction)
    {
        $charge = 500; // Сколько начислить баллов за регистрацию по реферальному коду

        $params = [
            'season' => $promoAction,
            'person' => $person,
            'points' => $charge,
            'type' => 'reference',
            'state' => 'none',
            'dt' => new \DateTime()
        ];

        $personPoints = PersonPoints::fromArray($params);
        $this->getPersonPointsRepository()->save($personPoints);

        return $charge;
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