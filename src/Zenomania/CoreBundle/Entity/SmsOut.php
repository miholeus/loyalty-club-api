<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * SmsOut
 */
class SmsOut
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $fromMobile;

    /**
     * @var string
     */
    private $toMobile;

    /**
     * @var integer
     */
    private $personId;

    /**
     * @var \DateTime
     */
    private $dt;

    /**
     * @var string
     */
    private $text;

    /**
     * @var string
     */
    private $type;

    /**
     * @var integer
     */
    private $numberSms = '0';

    /**
     * @var string
     */
    private $outerId = '';

    /**
     * @var string
     */
    private $status = '';

    /**
     * @var integer
     */
    private $smsIn;


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
     * Set fromMobile
     *
     * @param string $fromMobile
     *
     * @return SmsOut
     */
    public function setFromMobile($fromMobile)
    {
        $this->fromMobile = $fromMobile;

        return $this;
    }

    /**
     * Get fromMobile
     *
     * @return string
     */
    public function getFromMobile()
    {
        return $this->fromMobile;
    }

    /**
     * Set toMobile
     *
     * @param string $toMobile
     *
     * @return SmsOut
     */
    public function setToMobile($toMobile)
    {
        $this->toMobile = $toMobile;

        return $this;
    }

    /**
     * Get toMobile
     *
     * @return string
     */
    public function getToMobile()
    {
        return $this->toMobile;
    }

    /**
     * Set personId
     *
     * @param integer $personId
     *
     * @return SmsOut
     */
    public function setPersonId($personId)
    {
        $this->personId = $personId;

        return $this;
    }

    /**
     * Get personId
     *
     * @return integer
     */
    public function getPersonId()
    {
        return $this->personId;
    }

    /**
     * Set dt
     *
     * @param \DateTime $dt
     *
     * @return SmsOut
     */
    public function setDt($dt)
    {
        $this->dt = $dt;

        return $this;
    }

    /**
     * Get dt
     *
     * @return \DateTime
     */
    public function getDt()
    {
        return $this->dt;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return SmsOut
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return SmsOut
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set numberSms
     *
     * @param integer $numberSms
     *
     * @return SmsOut
     */
    public function setNumberSms($numberSms)
    {
        $this->numberSms = $numberSms;

        return $this;
    }

    /**
     * Get numberSms
     *
     * @return integer
     */
    public function getNumberSms()
    {
        return $this->numberSms;
    }

    /**
     * Set outerId
     *
     * @param string $outerId
     *
     * @return SmsOut
     */
    public function setOuterId($outerId)
    {
        $this->outerId = $outerId;

        return $this;
    }

    /**
     * Get outerId
     *
     * @return string
     */
    public function getOuterId()
    {
        return $this->outerId;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return SmsOut
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set smsIn
     *
     * @param integer $smsIn
     *
     * @return SmsOut
     */
    public function setSmsIn($smsIn)
    {
        $this->smsIn = $smsIn;

        return $this;
    }

    /**
     * Get smsIn
     *
     * @return integer
     */
    public function getSmsIn()
    {
        return $this->smsIn;
    }
}
