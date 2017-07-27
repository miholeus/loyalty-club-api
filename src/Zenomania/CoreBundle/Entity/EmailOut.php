<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * EmailOut
 */
class EmailOut
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $dt;

    /**
     * @var string
     */
    private $fromEmail;

    /**
     * @var string
     */
    private $toEmail;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $body;

    /**
     * @var string
     */
    private $type;

    /**
     * @var boolean
     */
    private $sended = '0';

    /**
     * @var \Zenomania\CoreBundle\Entity\Person
     */
    private $fromPerson;

    /**
     * @var \Zenomania\CoreBundle\Entity\Person
     */
    private $toPerson;


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
     * Set dt
     *
     * @param \DateTime $dt
     *
     * @return EmailOut
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
     * Set fromEmail
     *
     * @param string $fromEmail
     *
     * @return EmailOut
     */
    public function setFromEmail($fromEmail)
    {
        $this->fromEmail = $fromEmail;

        return $this;
    }

    /**
     * Get fromEmail
     *
     * @return string
     */
    public function getFromEmail()
    {
        return $this->fromEmail;
    }

    /**
     * Set toEmail
     *
     * @param string $toEmail
     *
     * @return EmailOut
     */
    public function setToEmail($toEmail)
    {
        $this->toEmail = $toEmail;

        return $this;
    }

    /**
     * Get toEmail
     *
     * @return string
     */
    public function getToEmail()
    {
        return $this->toEmail;
    }

    /**
     * Set subject
     *
     * @param string $subject
     *
     * @return EmailOut
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set body
     *
     * @param string $body
     *
     * @return EmailOut
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
     * Set type
     *
     * @param string $type
     *
     * @return EmailOut
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
     * Set sended
     *
     * @param boolean $sended
     *
     * @return EmailOut
     */
    public function setSended($sended)
    {
        $this->sended = $sended;

        return $this;
    }

    /**
     * Get sended
     *
     * @return boolean
     */
    public function getSended()
    {
        return $this->sended;
    }

    /**
     * Set fromPerson
     *
     * @param \Zenomania\CoreBundle\Entity\Person $fromPerson
     *
     * @return EmailOut
     */
    public function setFromPerson(\Zenomania\CoreBundle\Entity\Person $fromPerson = null)
    {
        $this->fromPerson = $fromPerson;

        return $this;
    }

    /**
     * Get fromPerson
     *
     * @return \Zenomania\CoreBundle\Entity\Person
     */
    public function getFromPerson()
    {
        return $this->fromPerson;
    }

    /**
     * Set toPerson
     *
     * @param \Zenomania\CoreBundle\Entity\Person $toPerson
     *
     * @return EmailOut
     */
    public function setToPerson(\Zenomania\CoreBundle\Entity\Person $toPerson = null)
    {
        $this->toPerson = $toPerson;

        return $this;
    }

    /**
     * Get toPerson
     *
     * @return \Zenomania\CoreBundle\Entity\Person
     */
    public function getToPerson()
    {
        return $this->toPerson;
    }
}
