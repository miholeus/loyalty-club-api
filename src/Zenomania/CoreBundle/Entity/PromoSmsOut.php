<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * PromoSmsOut
 */
class PromoSmsOut
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $tomobile;

    /**
     * @var integer
     */
    private $personId;

    /**
     * @var \DateTime
     */
    private $queuedAt;

    /**
     * @var \DateTime
     */
    private $sentAt;

    /**
     * @var string
     */
    private $content;

    /**
     * @var boolean
     */
    private $sent = '0';

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
     * Set tomobile
     *
     * @param string $tomobile
     *
     * @return PromoSmsOut
     */
    public function setTomobile($tomobile)
    {
        $this->tomobile = $tomobile;

        return $this;
    }

    /**
     * Get tomobile
     *
     * @return string
     */
    public function getTomobile()
    {
        return $this->tomobile;
    }

    /**
     * Set personId
     *
     * @param integer $personId
     *
     * @return PromoSmsOut
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
     * Set queuedAt
     *
     * @param \DateTime $queuedAt
     *
     * @return PromoSmsOut
     */
    public function setQueuedAt($queuedAt)
    {
        $this->queuedAt = $queuedAt;

        return $this;
    }

    /**
     * Get queuedAt
     *
     * @return \DateTime
     */
    public function getQueuedAt()
    {
        return $this->queuedAt;
    }

    /**
     * Set sentAt
     *
     * @param \DateTime $sentAt
     *
     * @return PromoSmsOut
     */
    public function setSentAt($sentAt)
    {
        $this->sentAt = $sentAt;

        return $this;
    }

    /**
     * Get sentAt
     *
     * @return \DateTime
     */
    public function getSentAt()
    {
        return $this->sentAt;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return PromoSmsOut
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set sent
     *
     * @param boolean $sent
     *
     * @return PromoSmsOut
     */
    public function setSent($sent)
    {
        $this->sent = $sent;

        return $this;
    }

    /**
     * Get sent
     *
     * @return boolean
     */
    public function getSent()
    {
        return $this->sent;
    }

    /**
     * Set smsIn
     *
     * @param integer $smsIn
     *
     * @return PromoSmsOut
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

