<?php
/**
 * @package    Zenomania\ApiBundle\Service\Transformer\User
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */


namespace Zenomania\ApiBundle\Service\Transformer\User;


use Zenomania\CoreBundle\Entity\User;

class UserInfoTransformer extends UserProfileTransformer
{
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