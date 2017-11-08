<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 07.11.17
 * Time: 14:28
 */

namespace Zenomania\CoreBundle\Form\Model;


use Zenomania\CoreBundle\Entity\DeliveryType;
use Zenomania\CoreBundle\Entity\OrderStatus;
use Zenomania\CoreBundle\Entity\Product;
use Zenomania\CoreBundle\Entity\User;

class Order
{
    /**
     * @var OrderStatus
     */
    private $statusId;

    /**
     * @var User
     */
    private $userId;

    /**
     * @var DeliveryType
     */
    private $deliveryTypeId;

    /**
     * @var float
     */
    private $price;

    /**
     * @var float
     */
    private $totalPrice;

    /**
     * @var string
     */
    private $note;

    /**
     * @var string
     */
    private $noteStatus;

    /**
     * @var string
     */
    private $noteDelivery;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $address;

    /**
     * @var integer
     */
    private $phone;

    /**
     * @var string
     */
    private $clientName;

    /**
     * @var Product
     */
    private $productId;

    /**
     * @var integer
     */
    private $quantity;

    /**
     * @return OrderStatus
     */
    public function getStatusId()
    {
        return $this->statusId;
    }

    /**
     * @param OrderStatus $statusId
     */
    public function setStatusId($statusId)
    {
        $this->statusId = $statusId;
    }

    /**
     * @return User
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param User $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return DeliveryType
     */
    public function getDeliveryTypeId()
    {
        return $this->deliveryTypeId;
    }

    /**
     * @param DeliveryType $deliveryTypeId
     */
    public function setDeliveryTypeId($deliveryTypeId)
    {
        $this->deliveryTypeId = $deliveryTypeId;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
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
    public function setNote($note)
    {
        $this->note = $note;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return int
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param int $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getClientName()
    {
        return $this->clientName;
    }

    /**
     * @param string $clientName
     */
    public function setClientName($clientName)
    {
        $this->clientName = $clientName;
    }

    /**
     * @return Product
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @param Product $productId
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

    /**
     * @return float
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * @param float $totalPrice
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;
    }

    /**
     * @return string
     */
    public function getNoteDelivery()
    {
        return $this->noteDelivery;
    }

    /**
     * @param string $noteDelivery
     */
    public function setNoteDelivery($noteDelivery)
    {
        $this->noteDelivery = $noteDelivery;
    }

    /**
     * @return string
     */
    public function getNoteStatus()
    {
        return $this->noteStatus;
    }

    /**
     * @param string $noteStatus
     */
    public function setNoteStatus( $noteStatus)
    {
        $this->noteStatus = $noteStatus;
    }
}