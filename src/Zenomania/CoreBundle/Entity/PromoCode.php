<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * PromoCode
 */
class PromoCode
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
    private $used = '0';

    /**
     * @var boolean
     */
    private $electronic = '0';

    /**
     * @var integer
     */
    private $email;

    /**
     * @var integer
     */
    private $barcode;

    /**
     * @var integer
     */
    private $outerId;

    /**
     * @var \DateTime
     */
    private $activatedDt;

    /**
     * @var \Zenomania\CoreBundle\Entity\PromoSmsIn
     */
    private $sms;

    /**
     * @var \Zenomania\CoreBundle\Entity\Ticket
     */
    private $ticket;

    /**
     * @var \Zenomania\CoreBundle\Entity\Season
     */
    private $season;
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
     * @return PromoCode
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
     * Set used
     *
     * @param integer $used
     *
     * @return PromoCode
     */
    public function setUsed($used)
    {
        $this->used = $used;

        return $this;
    }

    /**
     * Get used
     *
     * @return integer
     */
    public function getUsed()
    {
        return $this->used;
    }

    /**
     * Set electronic
     *
     * @param boolean $electronic
     *
     * @return PromoCode
     */
    public function setElectronic($electronic)
    {
        $this->electronic = $electronic;

        return $this;
    }

    /**
     * Get electronic
     *
     * @return boolean
     */
    public function getElectronic()
    {
        return $this->electronic;
    }

    /**
     * Set email
     *
     * @param integer $email
     *
     * @return PromoCode
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return integer
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set barcode
     *
     * @param integer $barcode
     *
     * @return PromoCode
     */
    public function setBarcode($barcode)
    {
        $this->barcode = $barcode;

        return $this;
    }

    /**
     * Get barcode
     *
     * @return integer
     */
    public function getBarcode()
    {
        return $this->barcode;
    }

    /**
     * Set outerId
     *
     * @param integer $outerId
     *
     * @return PromoCode
     */
    public function setOuterId($outerId)
    {
        $this->outerId = $outerId;

        return $this;
    }

    /**
     * Get outerId
     *
     * @return integer
     */
    public function getOuterId()
    {
        return $this->outerId;
    }

    /**
     * Set activatedDt
     *
     * @param \DateTime $activatedDt
     *
     * @return PromoCode
     */
    public function setActivatedDt($activatedDt)
    {
        $this->activatedDt = $activatedDt;

        return $this;
    }

    /**
     * Get activatedDt
     *
     * @return \DateTime
     */
    public function getActivatedDt()
    {
        return $this->activatedDt;
    }

    /**
     * Set sms
     *
     * @param \Zenomania\CoreBundle\Entity\PromoSmsIn $sms
     *
     * @return PromoCode
     */
    public function setSms(\Zenomania\CoreBundle\Entity\PromoSmsIn $sms = null)
    {
        $this->sms = $sms;

        return $this;
    }

    /**
     * Get sms
     *
     * @return \Zenomania\CoreBundle\Entity\PromoSmsIn
     */
    public function getSms()
    {
        return $this->sms;
    }

    /**
     * Set ticket
     *
     * @param \Zenomania\CoreBundle\Entity\Ticket $ticket
     *
     * @return PromoCode
     */
    public function setTicket(\Zenomania\CoreBundle\Entity\Ticket $ticket = null)
    {
        $this->ticket = $ticket;

        return $this;
    }

    /**
     * Get ticket
     *
     * @return \Zenomania\CoreBundle\Entity\Ticket
     */
    public function getTicket()
    {
        return $this->ticket;
    }

    /**
     * Set season
     *
     * @param \Zenomania\CoreBundle\Entity\Season $season
     *
     * @return PromoCode
     */
    public function setSeason(\Zenomania\CoreBundle\Entity\Season $season = null)
    {
        $this->season = $season;

        return $this;
    }

    /**
     * Get season
     *
     * @return \Zenomania\CoreBundle\Entity\Season
     */
    public function getSeason()
    {
        return $this->season;
    }
}
