<?php

namespace Zenomania\ApiBundle\Service\Transformer\User;

use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Service\Utils\HostBasedUrl;
use Zenomania\ApiBundle\Service\Transformer\TransformerAbstract;

class UserProfileTransformer extends TransformerAbstract
{
    /**
     * @var HostBasedUrl
     */
    private $url;

    public function __construct(HostBasedUrl $url)
    {
        $this->url = $url;
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
            'phone' => $user->getPhone()
        ];
    }
}