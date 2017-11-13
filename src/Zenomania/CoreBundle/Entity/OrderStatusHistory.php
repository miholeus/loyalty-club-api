<?php

namespace Zenomania\CoreBundle\Entity;

use Zenomania\CoreBundle\Form\Model\Order as OrderModel;
/**
 * OrderStatusHistory
 */
class OrderStatusHistory
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string|null
     */
    private $note;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \Zenomania\CoreBundle\Entity\OrderStatus
     */
    private $fromOrderStatusId;

    /**
     * @var \Zenomania\CoreBundle\Entity\OrderStatus
     */
    private $toOrderStatusId;

    /**
     * @var \Zenomania\CoreBundle\Entity\User
     */
    private $createdBy;

    /**
     * @var \Zenomania\CoreBundle\Entity\Order
     */
    private $orderId;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
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
     * Set note.
     *
     * @param string|null $note
     *
     * @return OrderStatusHistory
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
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return OrderStatusHistory
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
     * Set fromOrderStatusId.
     *
     * @param \Zenomania\CoreBundle\Entity\OrderStatus $fromOrderStatusId
     *
     * @return OrderStatusHistory
     */
    public function setFromOrderStatusId(\Zenomania\CoreBundle\Entity\OrderStatus $fromOrderStatusId)
    {
        $this->fromOrderStatusId = $fromOrderStatusId;

        return $this;
    }

    /**
     * Get fromOrderStatusId.
     *
     * @return \Zenomania\CoreBundle\Entity\OrderStatus
     */
    public function getFromOrderStatusId()
    {
        return $this->fromOrderStatusId;
    }

    /**
     * Set toOrderStatusId.
     *
     * @param \Zenomania\CoreBundle\Entity\OrderStatus $toOrderStatusId
     *
     * @return OrderStatusHistory
     */
    public function setToOrderStatusId(\Zenomania\CoreBundle\Entity\OrderStatus $toOrderStatusId)
    {
        $this->toOrderStatusId = $toOrderStatusId;

        return $this;
    }

    /**
     * Get toOrderStatusId.
     *
     * @return \Zenomania\CoreBundle\Entity\OrderStatus
     */
    public function getToOrderStatusId()
    {
        return $this->toOrderStatusId;
    }

    /**
     * Set createdBy.
     *
     * @param \Zenomania\CoreBundle\Entity\User $createdBy
     *
     * @return OrderStatusHistory
     */
    public function setCreatedBy(\Zenomania\CoreBundle\Entity\User $createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy.
     *
     * @return \Zenomania\CoreBundle\Entity\User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set orderId.
     *
     * @param \Zenomania\CoreBundle\Entity\Order $orderId
     *
     * @return OrderStatusHistory
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

    public static function fromOrderModel(OrderModel $orderModel){
        $self = new self();
        $self->setNote();
    }
}
