<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * PromoCouponAction
 */
class PromoCouponAction
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \DateTime
     */
    private $endDt;

    /**
     * @var boolean
     */
    private $isBlocked = '0';

    /**
     * @var boolean
     */
    private $allowedDays = '0';

    /**
     * @var \DateTime
     */
    private $createdOn;

    /**
     * @var \DateTime
     */
    private $updatedOn;

    public static function fromArray($data)
    {
        $self = new self();
        foreach ($data as $k => $v) {
            $self->{"set" . ucfirst($k)}($v);
        }
        return $self;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->createdOn = new \DateTime();
        $this->updatedOn = new \DateTime();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return PromoCouponAction
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set endDt
     *
     * @param \DateTime $endDt
     *
     * @return PromoCouponAction
     */
    public function setEndDt($endDt)
    {
        $this->endDt = $endDt;

        return $this;
    }

    /**
     * Get endDt
     *
     * @return \DateTime
     */
    public function getEndDt()
    {
        return $this->endDt;
    }

    /**
     * Set isBlocked
     *
     * @param boolean $isBlocked
     *
     * @return PromoCouponAction
     */
    public function setIsBlocked($isBlocked)
    {
        $this->isBlocked = $isBlocked;

        return $this;
    }

    /**
     * Get isBlocked
     *
     * @return boolean
     */
    public function getIsBlocked()
    {
        return $this->isBlocked;
    }

    /**
     * Set allowedDays
     *
     * @param boolean $allowedDays
     *
     * @return PromoCouponAction
     */
    public function setAllowedDays($allowedDays)
    {
        $this->allowedDays = $allowedDays;

        return $this;
    }

    /**
     * Get allowedDays
     *
     * @return boolean
     */
    public function getAllowedDays()
    {
        return $this->allowedDays;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @param \DateTime $createdOn
     *
     * @return PromoCouponAction
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }

    /**
     * @param \DateTime $updatedOn
     *
     * @return PromoCouponAction
     */
    public function setUpdatedOn($updatedOn)
    {
        $this->updatedOn = $updatedOn;

        return $this;
    }
}
