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
            'type_id' => $item['type_id'],
            'type_title' => $item['type_title'],
            'badge_title' => $item['badge_title'],
            'badge_code' => $item['badge_code'],
            'points' => $item['points'],
            'max_points' => $item['max_points'],
            'photo' => $item['photo'],
            'type_sort' => $item['type_sort'],
            'badge_sort' => $item['badge_sort'],
        ];
        return $data;
    }
}