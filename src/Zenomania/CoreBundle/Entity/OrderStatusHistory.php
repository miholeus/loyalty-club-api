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
     * @var int
     */
    private $fromOrderStatusId;

    /**
     * @var int
     */
    private $toOrderStatusId;

    /**
     * @var string|null
     */
    private $note;

    /**
     * @var int
     */
    private $orderId;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \Zenomania\CoreBundle\Entity\User
     */
    private $createdBy;


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
     * Set fromOrderStatusId.
     *
     * @param int $fromOrderStatusId
     *
     * @return OrderStatusHistory
     */
    public function setFromOrderStatusId($fromOrderStatusId)
    {
        $this->fromOrderStatusId = $fromOrderStatusId;

        return $this;
    }

    /**
     * Get fromOrderStatusId.
     *
     * @return int
     */
    public function getFromOrderStatusId()
    {
        return $this->fromOrderStatusId;
    }

    /**
     * Set toOrderStatusId.
     *
     * @param int $toOrderStatusId
     *
     * @return OrderStatusHistory
     */
    public function setToOrderStatusId($toOrderStatusId)
    {
        $this->toOrderStatusId = $toOrderStatusId;

        return $this;
    }

    /**
     * Get toOrderStatusId.
     *
     * @return int
     */
    public function getToOrderStatusId()
    {
        return $this->toOrderStatusId;
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
     * Set orderId.
     *
     * @param int $orderId
     *
     * @return OrderStatusHistory
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * Get orderId.
     *
     * @return int
     */
    public function getOrderId()
    {
        return $this->orderId;
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

    public static function fromOrderModel(OrderModel $orderModel){
        $self = new self();
        $self->setNote();
    }
}
