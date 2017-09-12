<?php

namespace Zenomania\ApiBundle\Service\Social;

use Zenomania\CoreBundle\Entity\SocialAccount;
use Doctrine\ORM\EntityManager;
use Zenomania\CoreBundle\Repository\SocialAccountRepository;

class UpdateSocialInfo
{
    /**
     * @var EntityManager
     */
    protected $em;

    protected $repository;

    public function __construct(SocialAccountRepository $accountRepository)
    {
        $this->repository =  $accountRepository;
    }

    public function save(SocialAccount $account)
    {
        $this->repository->update($account);
    }

    public function find(){
        $this->repository->find();
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->em;
    }

}
