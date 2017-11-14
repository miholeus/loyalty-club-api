<?php

namespace Zenomania\CoreBundle\Entity;

use Zenomania\CoreBundle\Form\Model\Order as OrderModel;
/**
 * OrderDelivery
 */
class OrderDelivery
{
  
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $clientName;

    /**
     * @var string|null
     */
    private $address;

    /**
     * @var string|null
     */
    private $phone;

    /**
     * @var string|null
     */
    private $note;

    /**
     * @var \Zenomania\CoreBundle\Entity\Order
     */
    private $orderId;

    /**
     * @var \Zenomania\CoreBundle\Entity\DeliveryType
     */
    private $deliveryTypeId;

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
     * Set clientName.
     *
     * @param string $clientName
     *
     * @return OrderDelivery
     */
    public function setClientName($clientName)
    {
        $this->clientName = $clientName;

        return $this;
    }

    /**
     * Get clientName.
     *
     * @return string
     */
    public function getClientName()
    {
        return $this->clientName;
    }

    /**
     * Set address.
     *
     * @param string|null $address
     *
     * @return OrderDelivery
     */
    public function setAddress($address = null)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address.
     *
     * @return string|null
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set phone.
     *
     * @param string|null $phone
     *
     * @return OrderDelivery
     */
    public function setPhone($phone = null)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone.
     *
     * @return string|null
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set note.
     *
     * @param string|null $note
     *
     * @return OrderDelivery
     */
    public function setNote($note = null)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note.
     *
     * @return string|null
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set orderId.
     *
     * @param \Zenomania\CoreBundle\Entity\Order $orderId
     *
     * @return OrderDelivery
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
     * Set deliveryTypeId.
     *
     * @param \Zenomania\CoreBundle\Entity\DeliveryType $deliveryTypeId
     *
     * @return OrderDelivery
     */
    public function setDeliveryTypeId(\Zenomania\CoreBundle\Entity\DeliveryType $deliveryTypeId)
    {
        $this->deliveryTypeId = $deliveryTypeId;

        return $this;
    }

    /**
     * Get deliveryTypeId.
     *
     * @return \Zenomania\CoreBundle\Entity\DeliveryType
     */
    public function getDeliveryTypeId()
    {
        return $this->deliveryTypeId;
    }

    public function fromOrderModel(OrderModel $orderModel){
        $this->setClientName($orderModel->getClientName());
        $this->setAddress($orderModel->getAddress());
        $this->setPhone($orderModel->getPhone());
        $this->setDeliveryTypeId($orderModel->getDeliveryTypeId());
        $this->setNote($orderModel->getNote());
    }
}