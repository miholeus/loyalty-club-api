<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 20.11.17
 * Time: 15:32
 */

namespace Zenomania\ApiBundle\Form\Model;


use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

class Order
{
    /**
     * @var string
     */
    private $note;

    /**
     * @Assert\NotBlank()
     * @var ArrayCollection
     */
    private $orderCart;

    /**
     * @Assert\NotBlank()
     * @var OrderDelivery
     */
    private $orderDelivery;

    public function __construct()
    {
        $this->orderCart = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getOrderCart()
    {
        return $this->orderCart;
    }

    /**
     * @param $orderCart
     */
    public function setOrderCart($orderCart)
    {
        $this->orderCart = $orderCart;
    }

    /**
     * @return OrderDelivery
     */
    public function getOrderDelivery()
    {
        return $this->orderDelivery;
    }

    /**
     * @param OrderDelivery $orderDelivery
     */
    public function setOrderDelivery($orderDelivery)
    {
        $this->orderDelivery = $orderDelivery;
    }

    /**
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param string $note
     */
    public function setNote( $note)
    {
        $this->note = $note;
    }
}