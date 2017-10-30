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
            'id' => $item['id'],
            'text' => $item['text'],
            'dt' => $item['dt'],
            'photo' => $item['photo'],
            'video' => $item['video'],
        ];
        return $data;
    }
}