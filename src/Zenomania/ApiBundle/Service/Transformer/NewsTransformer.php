<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 30.10.17
 * Time: 12:33
 */

namespace Zenomania\ApiBundle\Service\Transformer;


use Zenomania\CoreBundle\Entity\News;
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

    public function transform(News $news)
    {
        $data = [
            'id' => $news->getId(),
            'text' => $news->getText(),
            'tags' => $news->getTags(),
            'photo' => $news->getPhoto(),
            'video' => $news->getVideo(),
            'date' => $news->getDt()->getTimestamp(),
            'vk_share_link' => $news->getVkId() ? $this->getLink($news->getVkId()) : null,
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