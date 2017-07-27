<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * EmailDispatchTo
 */
class EmailDispatchTo
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $personId;

    /**
     * @var string
     */
    private $personEmail;

    /**
     * @var string
     */
    private $body;

    /**
     * @var boolean
     */
    private $sent = '0';

    /**
     * @var string
     */
    private $unsubscribeToken = '';

    /**
     * @var string
     */
    private $state = 'queued';

    /**
     * @var \Zenomania\CoreBundle\Entity\EmailDispatchDone
     */
    private $ed;


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
     * Set personId
     *
     * @param integer $personId
     *
     * @return EmailDispatchTo
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
     * Set personEmail
     *
     * @param string $personEmail
     *
     * @return EmailDispatchTo
     */
    public function setPersonEmail($personEmail)
    {
        $this->personEmail = $personEmail;

        return $this;
    }

    /**
     * Get personEmail
     *
     * @return string
     */
    public function getPersonEmail()
    {
        return $this->personEmail;
    }

    /**
     * Set body
     *
     * @param string $body
     *
     * @return EmailDispatchTo
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set sent
     *
     * @param boolean $sent
     *
     * @return EmailDispatchTo
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
     * Set unsubscribeToken
     *
     * @param string $unsubscribeToken
     *
     * @return EmailDispatchTo
     */
    public function setUnsubscribeToken($unsubscribeToken)
    {
        $this->unsubscribeToken = $unsubscribeToken;

        return $this;
    }

    /**
     * Get unsubscribeToken
     *
     * @return string
     */
    public function getUnsubscribeToken()
    {
        return $this->unsubscribeToken;
    }

    /**
     * Set state
     *
     * @param string $state
     *
     * @return EmailDispatchTo
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
     * Set ed
     *
     * @param \Zenomania\CoreBundle\Entity\EmailDispatchDone $ed
     *
     * @return EmailDispatchTo
     */
    public function setEd(\Zenomania\CoreBundle\Entity\EmailDispatchDone $ed = null)
    {
        $this->ed = $ed;

        return $this;
    }

    /**
     * Get ed
     *
     * @return \Zenomania\CoreBundle\Entity\EmailDispatchDone
     */
    public function getEd()
    {
        return $this->ed;
    }
}
