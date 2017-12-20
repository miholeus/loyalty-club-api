<?php

namespace Zenomania\ApiBundle\Service\Transformer\User;

use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Repository\PersonPointsRepository;
use Zenomania\CoreBundle\Service\Utils\HostBasedUrl;
use Zenomania\ApiBundle\Service\Transformer\TransformerAbstract;

class UserProfileTransformer extends TransformerAbstract
{
    /**
     * @var HostBasedUrl
     */
    protected $url;
    /**
     * @var PersonPointsRepository
     */
    protected $repository;

    public function __construct(HostBasedUrl $url, PersonPointsRepository $repository)
    {
        $this->url = $url;
        $this->repository = $repository;
    }

    public function transform(User $user)
    {
        return [
            'id' => $user->getId(),
            'avatar' => $this->url->getUrl($user->getAvatar()),
            'avatar_small' => $this->url->getUrl($user->getAvatarSmall()),
            'birth_date' => $this->formatTimestamp($user->getBirthDate()),
            'email' => $user->getEmail(),
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'middle_name' => $user->getMiddleName(),
            'login' => $user->getLogin(),
            'phone' => $user->getPhone(),
            'rating' => $this->getRepository()->getTotalPoints($user),
            'highest_place' => $this->getRepository()->getRating($user)
        ];
    }

    /**
     * @return PersonPointsRepository
     */
    public function getRepository(): PersonPointsRepository
    {
        return $this->repository;
    }
}