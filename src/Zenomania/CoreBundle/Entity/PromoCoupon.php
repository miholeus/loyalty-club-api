<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * PromoCoupon
 */
class PromoCoupon
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $code;

    /**
     * @var integer
     */
    private $points;

    /**
     * @var boolean
     */
    private $activated = false;

    /**
     * @var \Zenomania\CoreBundle\Entity\PromoCouponAction
     */
    private $action;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $personPoint;

    /**
     * @var \DateTime
     */
    private $createdOn;

    /**
     * @var \DateTime
     */
    private $updatedOn;

    /**
     * @var \Zenomania\CoreBundle\Entity\User
     */
    private $createdBy;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->personPoint = new \Doctrine\Common\Collections\ArrayCollection();
        $this->createdOn = new \DateTime();
        $this->updatedOn = new \DateTime();
    }

    public static function fromArray($data)
    {
        $self = new self();
        foreach ($data as $key => $value) {
            $self->{"set".ucfirst($key)}($value);
        }
        return $self;
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
     * Set code
     *
     * @param string $code
     *
     * @return PromoCoupon
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set points
     *
     * @param integer $points
     *
     * @return PromoCoupon
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get points
     *
     * @return integer
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Set activated
     *
     * @param boolean $activated
     *
     * @return PromoCoupon
     */
    public function setActivated($activated)
    {
        $this->activated = $activated;

        return $this;
    }

    /**
     * Get activated
     *
     * @return boolean
     */
    public function getActivated()
    {
        return $this->activated;
    }

    /**
     * Set action
     *
     * @param \Zenomania\CoreBundle\Entity\PromoCouponAction $action
     *
     * @return PromoCoupon
     */
    public function setAction(\Zenomania\CoreBundle\Entity\PromoCouponAction $action = null)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return \Zenomania\CoreBundle\Entity\PromoCouponAction
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Add personPoint
     *
     * @param \Zenomania\CoreBundle\Entity\PersonPoints $personPoint
     *
     * @return PromoCoupon
     */
    public function addPersonPoint(\Zenomania\CoreBundle\Entity\PersonPoints $personPoint)
    {
        $this->personPoint[] = $personPoint;

        return $this;
    }

    /**
     * Remove personPoint
     *
     * @param \Zenomania\CoreBundle\Entity\PersonPoints $personPoint
     */
    public function removePersonPoint(\Zenomania\CoreBundle\Entity\PersonPoints $personPoint)
    {
        $this->personPoint->removeElement($personPoint);
    }

    /**
     * Get personPoint
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPersonPoint()
    {
        return $this->personPoint;
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
     * @return PromoCoupon
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
     * @return PromoCoupon
     */
    public function setUpdatedOn($updatedOn)
    {
        $this->updatedOn = $updatedOn;

        return $this;
    }

    /**
     * Set createdBy
     *
     * @param \Zenomania\CoreBundle\Entity\User $createdBy
     *
     * @return PromoCoupon
     */
    public function setCreatedBy(\Zenomania\CoreBundle\Entity\User $createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return \Zenomania\CoreBundle\Entity\User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }
}
