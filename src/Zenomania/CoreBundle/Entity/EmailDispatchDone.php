<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * EmailDispatchDone
 */
class EmailDispatchDone
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $recipientCode;

    /**
     * @var \DateTime
     */
    private $date = '0000-00-00 00:00:00';

    /**
     * @var string
     */
    private $state;

    /**
     * @var \Zenomania\CoreBundle\Entity\Actor
     */
    private $actor;

    /**
     * @var \Zenomania\CoreBundle\Entity\EmailDispatch
     */
    private $emailDispatch;


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
     * Set recipientCode
     *
     * @param string $recipientCode
     *
     * @return EmailDispatchDone
     */
    public function setRecipientCode($recipientCode)
    {
        $this->recipientCode = $recipientCode;

        return $this;
    }

    /**
     * Get recipientCode
     *
     * @return string
     */
    public function getRecipientCode()
    {
        return $this->recipientCode;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return EmailDispatchDone
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set state
     *
     * @param string $state
     *
     * @return EmailDispatchDone
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set actor
     *
     * @param \Zenomania\CoreBundle\Entity\Actor $actor
     *
     * @return EmailDispatchDone
     */
    public function setActor(\Zenomania\CoreBundle\Entity\Actor $actor = null)
    {
        $this->actor = $actor;

        return $this;
    }

    /**
     * Get actor
     *
     * @return \Zenomania\CoreBundle\Entity\Actor
     */
    public function getActor()
    {
        return $this->actor;
    }

    /**
     * Set emailDispatch
     *
     * @param \Zenomania\CoreBundle\Entity\EmailDispatch $emailDispatch
     *
     * @return EmailDispatchDone
     */
    public function setEmailDispatch(\Zenomania\CoreBundle\Entity\EmailDispatch $emailDispatch = null)
    {
        $this->emailDispatch = $emailDispatch;

        return $this;
    }

    /**
     * Get emailDispatch
     *
     * @return \Zenomania\CoreBundle\Entity\EmailDispatch
     */
    public function getEmailDispatch()
    {
        return $this->emailDispatch;
    }
}
