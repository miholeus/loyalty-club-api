<?php

namespace Zenomania\ApiBundle\Service\Social;

use Zenomania\CoreBundle\Entity\SocialAccount;
use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Repository\SocialAccountRepository;
class UpdateSocialInfo
{
    protected $repository;

    protected $bonusPoints;

    public function __construct(SocialAccountRepository $accountRepository, BonusPoints $bonusPoints)
    {
        $this->repository =  $accountRepository;
        $this->bonusPoints = $bonusPoints;
    }

    public function save(SocialAccount $account, User $user)
    {
       $isExist = $this->repository->update($account);
       if(!$isExist){
           $this->bonusPoints->givePointsForSocialBind($user);
       }
    }

    public function find(){
        $this->repository->find();

    }
}
