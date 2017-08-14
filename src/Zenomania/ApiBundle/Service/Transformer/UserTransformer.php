<?php
/**
 * @package    Zenomania\ApiBundle\Service\Transformer
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */


namespace Zenomania\ApiBundle\Service\Transformer;

use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Service\Utils\HostBasedUrl;

class UserTransformer extends TransformerAbstract
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
            'photo' => $this->url->getUrl($user->getAvatarSmall()),
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'middle_name' => $user->getMiddleName()
        ];
    }
}