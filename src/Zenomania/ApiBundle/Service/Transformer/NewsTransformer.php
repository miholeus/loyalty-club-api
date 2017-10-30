<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 30.10.17
 * Time: 12:33
 */

namespace Zenomania\ApiBundle\Service\Transformer;


use Zenomania\CoreBundle\Service\Utils\HostBasedUrl;

class NewsTransformer extends TransformerAbstract
{
    const VK_BASE_POST_URL = 'https://vk.com/volleyzenit?w=wall';

    /**
     * @var HostBasedUrl
     */
    private $url;

    /**
     * @var int
     */
    private $vkGroupId;

    public function __construct(HostBasedUrl $url, int $vkGroupId)
    {
        $this->vkGroupId = $vkGroupId;
        $this->url = $url;

    }

    public function transform(array $item)
    {
        $data = [
            'id' => $item['id'],
            'text' => $item['text'],
            'tags' => $item['tags'],
            'photo' => $item['photo'],
            'video' => $item['video'],
            'dt' => $item['dt'],
            'link' => $this->getLink($item['vk_id']),
        ];

        return $data;
    }

    public function getLink(int $vkPostId)
    {
        return self::VK_BASE_POST_URL. $this->getVkGroupId(). '_' . $vkPostId;
    }

    /**
     * @return int
     */
    public function getVkGroupId(): int
    {
        return $this->vkGroupId;
    }
}