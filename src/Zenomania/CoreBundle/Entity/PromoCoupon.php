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
    private $activated = '0';

    /**
     * @var \Zenomania\CoreBundle\Entity\PromoCouponAction
     */
    private $pcaction;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $personPoint;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->personPoint = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set pcaction
     *
     * @param \Zenomania\CoreBundle\Entity\PromoCouponAction $pcaction
     *
     * @return PromoCoupon
     */
    public function setPcaction(\Zenomania\CoreBundle\Entity\PromoCouponAction $pcaction = null)
    {
        $this->pcaction = $pcaction;

        return $this;
    }

    /**
     * Get pcaction
     *
     * @return \Zenomania\CoreBundle\Entity\PromoCouponAction
     */
    public function getPcaction()
    {
        return $this->pcaction;
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
}
