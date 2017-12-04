<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 01.12.17
 * Time: 19:18
 */

namespace Zenomania\ApiBundle\Service;


use Zenomania\CoreBundle\Repository\ProductRepository;

class Product
{

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * Product constructor.
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getProducts()
    {
        return $this->getProductRepository()->findBy(['published' => true]);
    }

    /**
     * @return ProductRepository
     */
    public function getProductRepository(): ProductRepository
    {
        return $this->productRepository;
    }
}