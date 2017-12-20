<?php
/**
 * Created by PhpStorm.
 * User: igorvolkov
 * Date: 19.12.2017
 * Time: 22:27
 */

namespace Zenomania\ApiBundle\Service\Transformer;


use Zenomania\CoreBundle\Entity\Product;
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

    public function transform(Product $item)
    {
        $data = [
            'id' => $item->getId(),
            'title' => $item->getTitle(),
            'photo' => $item->getPhoto(),
            'category' => [
                'id' => $item->getCategoryId()->getId(),
                'title' => $item->getCategoryId()->getTitle(),
            ],
        ];
        return $data;
    }

}