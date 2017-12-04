<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 01.12.17
 * Time: 19:24
 */

namespace Zenomania\ApiBundle\Service\Transformer;


use Zenomania\CoreBundle\Entity\Product;
use Zenomania\CoreBundle\Service\Utils\HostBasedUrl;

class ProductTransformer extends TransformerAbstract
{
    /**
     * @var HostBasedUrl
     */
    private $url;

    public function __construct(HostBasedUrl $url)
    {
        $this->url = $url;
    }

    /**
     * Transforms products
     *
     * @param array $products
     * @return array
     */
    public function transform(array $products)
    {
        $items = array();
        foreach ($products as $product) {
            $productCategory = array();
            /** @var Product $product */
            if (!array_key_exists($product->getCategoryId()->getId(), $items)) {
                $productCategory['id'] = $product->getCategoryId()->getId();
                $productCategory['title'] = $product->getCategoryId()->getTitle();
                $productCategory['products'][] = [
                    'id' => $product->getId(),
                    'title' => $product->getTitle(),
                    'description' => $product->getDescription(),
                    'photo' => $product->getPhoto(),
                    'price' => $product->getPrice(),

                ];
                $items[$product->getCategoryId()->getId()] = $productCategory;
            } else {
                $items[$product->getCategoryId()->getId()]['products'][] =
                    [
                        'id' => $product->getId(),
                        'title' => $product->getTitle(),
                        'description' => $product->getDescription(),
                        'photo' => $product->getPhoto(),
                        'price' => $product->getPrice(),

                    ];
            }
        }
        return $items;
    }
}