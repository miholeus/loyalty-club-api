<?php

namespace Zenomania\ApiBundle\Service\Social;

use Zenomania\CoreBundle\Entity\SocialAccount;
use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Repository\SocialAccountRepository;

class UpdateSocialInfo
{
    /**
     * Social account repository
     *
     * @var SocialAccountRepository
     */
    protected $repository;
    /**
     * Bonus points service
     *
     * @var BonusPoints
     */
    protected $bonusPoints;

    public function __construct(SocialAccountRepository $accountRepository, BonusPoints $bonusPoints)
    {
        $this->repository = $accountRepository;
        $this->bonusPoints = $bonusPoints;
    }

    /**
     * Saves social account
     *
     * @param SocialAccount $account
     * @param User $user
     */
    public function save(SocialAccount $account, User $user)
    {
        $current = $this->repository->findAccountByOuterId($account);

        if (!$current) {
            $this->repository->save($account);
            // trigger new event
            if ($account->getOuterId()) {
                $this->bonusPoints->givePointsForSocialBind($user);
            }
        }
    }
}
