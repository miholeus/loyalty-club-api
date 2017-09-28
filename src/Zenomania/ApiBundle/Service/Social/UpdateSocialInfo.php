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
     */
    public function save(SocialAccount $account)
    {
        $current = $this->getRepository()->findAccountByOuterId($account);

        if (!$current) {
            // trigger new event
            if ($account->getOuterId()) {
                $this->getBonusPoints()->givePointsForSocialBind($account->getUser());
            }
        } else {
            $current->setUser($account->getUser());
            $current->setFirstName($account->getFirstName());
            $current->setLastName($account->getLastName());
            $current->setEmail($account->getEmail());
            $current->setBdate($account->getBdate());
            $current->setAccessToken($account->getAccessToken());
            $account = $current;
        }
        $this->getRepository()->save($account);
    }

    /**
     * @return SocialAccountRepository
     */
    public function getRepository(): SocialAccountRepository
    {
        return $this->repository;
    }

    /**
     * @return BonusPoints
     */
    public function getBonusPoints(): BonusPoints
    {
        return $this->bonusPoints;
    }
}
