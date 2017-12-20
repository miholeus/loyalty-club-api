<?php
/**
 * Created by PhpStorm.
 * User: igorvolkov
 * Date: 19.12.2017
 * Time: 22:27
 */

namespace Zenomania\ApiBundle\Service\Transformer;

use Zenomania\CoreBundle\Service\Utils\HostBasedUrl;

class PrizeTransformer extends TransformerAbstract
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
            'title' => $item['title'],
            'photo' => $item['photo'],
            'attachment' => $item['attachment'],
        ];
        return $data;
    }

}