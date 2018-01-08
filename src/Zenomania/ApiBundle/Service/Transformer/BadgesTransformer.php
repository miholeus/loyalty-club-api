<?php
/**
 * Created by PhpStorm.
 * User: igorvolkov
 * Date: 27.10.17
 * Time: 15:31
 */

namespace Zenomania\ApiBundle\Service\Transformer;


use Zenomania\CoreBundle\Service\Utils\HostBasedUrl;

class BadgesTransformer extends TransformerAbstract
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
            'type' => [
                'id' => $item['type_id'],
                'title' => $item['type_title'],
                'sort' => $item['type_sort'],
            ],
            'title' => $item['badge_title'],
            'code' => $item['badge_code'],
            'points' => $item['points'],
            'max_points' => $item['max_points'],
            'photo' =>  $this->url->getUrl($item['points'] < $item['max_points'] ? $item['photo'] : $item['photo_badge']),
            'sort' => $item['badge_sort'],
        ];
        return $data;
    }
}