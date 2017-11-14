<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 07.11.17
 * Time: 14:28
 */

namespace Zenomania\CoreBundle\Form\Model;


use Zenomania\CoreBundle\Entity\DeliveryType;
use Zenomania\CoreBundle\Entity\OrderDelivery;
use Zenomania\CoreBundle\Entity\OrderStatus;
use Zenomania\CoreBundle\Entity\OrderStatusHistory;
use Zenomania\CoreBundle\Entity\Product;
use Zenomania\CoreBundle\Entity\User;
use \Zenomania\CoreBundle\Entity\Order as EntityOrder;

class Order
{
    /**
     * @var integer
     */
    private $id;

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
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

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

    public function __construct()
    {
        $this->setUpdatedAt(new \DateTime());
    }

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
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
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
    public function setNoteStatus($noteStatus)
    {
        $this->noteStatus = $noteStatus;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getOrderData(
        EntityOrder &$order,
        OrderStatusHistory &$orderStatusHistory,
        OrderDelivery &$orderDelivery
    ) {
        $order->setStatusId($this->getStatusId());
        $order->setNote($this->getNote());

        $orderStatusHistory->setNote($this->getNote());
        $orderStatusHistory->setToOrderStatusId($this->getStatusId());

        $orderDelivery->setOrderId($order);
        $orderDelivery->setClientName($this->getClientName());
        $orderDelivery->setAddress($this->getAddress());
        $orderDelivery->setPhone($this->getPhone());
        $orderDelivery->setNote($this->getNoteDelivery());
        $orderDelivery->setDeliveryTypeId($this->getDeliveryTypeId());
    }
}