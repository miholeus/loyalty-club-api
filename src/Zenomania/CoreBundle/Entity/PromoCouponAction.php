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
    private $caption;

    /**
     * @var \DateTime
     */
    private $endDt;

    /**
     * @var boolean
     */
    private $isBlocked = '0';

    /**
     * @var string
     */
    private $pcaType = 'normal';

    /**
     * @var boolean
     */
    private $allowedDays = '0';

    /**
     * @var \Zenomania\CoreBundle\Entity\Club
     */
    private $clubOwner;


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
     * Set caption
     *
     * @param string $caption
     *
     * @return PromoCouponAction
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;

        return $this;
    }

    /**
     * Get caption
     *
     * @return string
     */
    public function getCaption()
    {
        return $this->caption;
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
     * Set pcaType
     *
     * @param string $pcaType
     *
     * @return PromoCouponAction
     */
    public function setPcaType($pcaType)
    {
        $this->pcaType = $pcaType;

        return $this;
    }

    /**
     * Get pcaType
     *
     * @return string
     */
    public function getPcaType()
    {
        return $this->pcaType;
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
     * Set clubOwner
     *
     * @param \Zenomania\CoreBundle\Entity\Club $clubOwner
     *
     * @return PromoCouponAction
     */
    public function setClubOwner(\Zenomania\CoreBundle\Entity\Club $clubOwner = null)
    {
        $this->clubOwner = $clubOwner;

        return $this;
    }

    /**
     * Get clubOwner
     *
     * @return \Zenomania\CoreBundle\Entity\Club
     */
    public function getClubOwner()
    {
        return $this->clubOwner;
    }
}
