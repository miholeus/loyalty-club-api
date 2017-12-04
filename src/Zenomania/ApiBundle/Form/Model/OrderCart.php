<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 20.11.17
 * Time: 18:23
 */

namespace Zenomania\ApiBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

class OrderCart
{
    /**
     * @Assert\NotBlank()
     * @var integer
     */
    private $productId;

    /**
     * @Assert\NotBlank()
     * @var integer
     */
    private $quantity;

    /**
     * @return int
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @param int $productId
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }
}