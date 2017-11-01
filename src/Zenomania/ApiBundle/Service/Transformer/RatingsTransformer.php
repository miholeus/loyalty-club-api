<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 28.09.17
 * Time: 15:00
 */

namespace Zenomania\ApiBundle\Service\Transformer;

use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Service\Utils\HostBasedUrl;

class RatingsTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['user'];
    /**
     * @var HostBasedUrl
     */
    private $url;

    public function __construct(HostBasedUrl $url)
    {
        $this->url = $url;
    }

    public function transform(array $item)
    {
        $data = [
            'position'     => $item['position'],
            'points'       => $item['points'],
        ];
        return $data;
    }

    public function includeUser(array $item)
    {
        $user = User::fromArray([
            'id' => $item['user_id'],
            'avatarSmall' => $item['avatar'],
            'firstname' => $item['firstname'],
            'lastname' => $item['lastname'],
            'middlename' => $item['middlename']
        ]);
        return $this->item($user, new UserTransformer($this->url));
    }
}