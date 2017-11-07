<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * Orders
 */
class Order
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $price;

    /**
     * @var string
     */
    private $note;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime|null
     */
    private $updatedAt;

    /**
     * @var \Zenomania\CoreBundle\Entity\OrderStatus
     */
    private $statusId;

    /**
     * @var \Zenomania\CoreBundle\Entity\User
     */
    private $userId;


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
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return Order
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set price.
     *
     * @param string $price
     *
     * @return Order
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price.
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set note.
     *
     * @param string $note
     *
     * @return Order
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note.
     *
     * @return string
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
     * @return Order
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
     * Set updatedAt.
     *
     * @param \DateTime|null $updatedAt
     *
     * @return Order
     */
    public function setUpdatedAt($updatedAt = null)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt.
     *
     * @return \DateTime|null
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set statusId.
     *
     * @param \Zenomania\CoreBundle\Entity\OrderStatus $statusId
     *
     * @return Order
     */
    public function setStatusId(\Zenomania\CoreBundle\Entity\OrderStatus $statusId)
    {
        $this->statusId = $statusId;

        return $this;
    }

    /**
     * Get statusId.
     *
     * @return \Zenomania\CoreBundle\Entity\OrderStatus
     */
    public function getStatusId()
    {
        return $this->statusId;
    }

    /**
     * Set userId.
     *
     * @param \Zenomania\CoreBundle\Entity\User $userId
     *
     * @return Order
     */
    public function setUserId(\Zenomania\CoreBundle\Entity\User $userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId.
     *
     * @return \Zenomania\CoreBundle\Entity\User
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
