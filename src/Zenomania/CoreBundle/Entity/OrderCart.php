<?php

namespace Zenomania\CoreBundle\Entity;

use \Zenomania\CoreBundle\Form\Model\Order as OrderModel;
/**
 * OrderCart
 */
class OrderCart
{
   
      /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $quantity;

    /**
     * @var float
     */
    private $price;

    /**
     * @var float
     */
    private $totalPrice;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \Zenomania\CoreBundle\Entity\Order
     */
    private $orderId;

    /**
     * @var \Zenomania\CoreBundle\Entity\Product
     */
    private $productId;


    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }
    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set quantity.
     *
     * @param int $quantity
     *
     * @return OrderCart
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity.
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set price.
     *
     * @param float $price
     *
     * @return OrderCart
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price.
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set totalPrice.
     *
     * @param float $totalPrice
     *
     * @return OrderCart
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    /**
     * Get float.
     *
     * @return float
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return OrderCart
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set orderId.
     *
     * @param \Zenomania\CoreBundle\Entity\Order $orderId
     *
     * @return OrderCart
     */
    public function setOrderId(\Zenomania\CoreBundle\Entity\Order $orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * Get orderId.
     *
     * @return \Zenomania\CoreBundle\Entity\Order
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * Set productId.
     *
     * @param \Zenomania\CoreBundle\Entity\Product $productId
     *
     * @return OrderCart
     */
    public function setProductId(\Zenomania\CoreBundle\Entity\Product $productId)
    {
        $this->productId = $productId;

        return $this;
    }

    /**
     * Get productId.
     *
     * @return \Zenomania\CoreBundle\Entity\Product
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @param OrderModel $orderModel
     * @return OrderCart
     */
    public static function fromOrderModel(OrderModel $orderModel){
        $self = new self();
        $self->setQuantity($orderModel->getQuantity());
        $self->setPrice($orderModel->getPrice());
        $self->setTotalPrice($orderModel->getTotalPrice());
        $self->setProductId($orderModel->getProductId());
        return $self;
    }
}
