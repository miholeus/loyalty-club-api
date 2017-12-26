<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * Payment
 */
class Payment
{

    const TYPE_DEBIT = 'debit';
    const TYPE_CREDIT = 'credit';

    /**
     * @var int
     */
    private $id;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var string
     */
    private $type;

    /**
     * @var \Zenomania\CoreBundle\Entity\User
     */
    private $user;

    /**
     * @var \DateTime
     */
    private $createdOn;

    public function __construct()
    {
        $this->createdOn = new \DateTime();
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
     * Set $amount.
     *
     * @param float $amount
     *
     * @return Payment
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount.
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set type.
     *
     * @param string $type
     *
     * @return Payment
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set user.
     *
     * @param \Zenomania\CoreBundle\Entity\User|null $user
     *
     * @return Payment
     */
    public function setUser(\Zenomania\CoreBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \Zenomania\CoreBundle\Entity\User|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set createdOn.
     *
     * @param \DateTime $createdOn
     *
     * @return Payment
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    /**
     * Get createdOn.
     *
     * @return \DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }
}
