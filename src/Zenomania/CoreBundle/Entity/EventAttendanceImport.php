<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * EventAttendanceImport
 */
class EventAttendanceImport
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $price = '0';

    /**
     * @var integer
     */
    private $ticketNumber;

    /**
     * @var string
     */
    private $subscriptionNumber;

    /**
     * @var \DateTime
     */
    private $enterDt;

    /**
     * @var boolean
     */
    private $electronic = '0';

    /**
     * @var integer
     */
    private $placeBuy = '0';

    /**
     * @var \DateTime
     */
    private $timeBuy;

    /**
     * @var string
     */
    private $fio;

    /**
     * @var \Zenomania\CoreBundle\Entity\Event
     */
    private $event;

    /**
     * @var \Zenomania\CoreBundle\Entity\Person
     */
    private $person;


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
     * Set price
     *
     * @param integer $price
     *
     * @return EventAttendanceImport
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set ticketNumber
     *
     * @param integer $ticketNumber
     *
     * @return EventAttendanceImport
     */
    public function setTicketNumber($ticketNumber)
    {
        $this->ticketNumber = $ticketNumber;

        return $this;
    }

    /**
     * Get ticketNumber
     *
     * @return integer
     */
    public function getTicketNumber()
    {
        return $this->ticketNumber;
    }

    /**
     * Set subscriptionNumber
     *
     * @param string $subscriptionNumber
     *
     * @return EventAttendanceImport
     */
    public function setSubscriptionNumber($subscriptionNumber)
    {
        $this->subscriptionNumber = $subscriptionNumber;

        return $this;
    }

    /**
     * Get subscriptionNumber
     *
     * @return string
     */
    public function getSubscriptionNumber()
    {
        return $this->subscriptionNumber;
    }

    /**
     * Set enterDt
     *
     * @param \DateTime $enterDt
     *
     * @return EventAttendanceImport
     */
    public function setEnterDt($enterDt)
    {
        $this->enterDt = $enterDt;

        return $this;
    }

    /**
     * Get enterDt
     *
     * @return \DateTime
     */
    public function getEnterDt()
    {
        return $this->enterDt;
    }

    /**
     * Set electronic
     *
     * @param boolean $electronic
     *
     * @return EventAttendanceImport
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
     * Set placeBuy
     *
     * @param integer $placeBuy
     *
     * @return EventAttendanceImport
     */
    public function setPlaceBuy($placeBuy)
    {
        $this->placeBuy = $placeBuy;

        return $this;
    }

    /**
     * Get placeBuy
     *
     * @return integer
     */
    public function getPlaceBuy()
    {
        return $this->placeBuy;
    }

    /**
     * Set timeBuy
     *
     * @param \DateTime $timeBuy
     *
     * @return EventAttendanceImport
     */
    public function setTimeBuy($timeBuy)
    {
        $this->timeBuy = $timeBuy;

        return $this;
    }

    /**
     * Get timeBuy
     *
     * @return \DateTime
     */
    public function getTimeBuy()
    {
        return $this->timeBuy;
    }

    /**
     * Set fio
     *
     * @param string $fio
     *
     * @return EventAttendanceImport
     */
    public function setFio($fio)
    {
        $this->fio = $fio;

        return $this;
    }

    /**
     * Get fio
     *
     * @return string
     */
    public function getFio()
    {
        return $this->fio;
    }

    /**
     * Set event
     *
     * @param \Zenomania\CoreBundle\Entity\Event $event
     *
     * @return EventAttendanceImport
     */
    public function setEvent(\Zenomania\CoreBundle\Entity\Event $event = null)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return \Zenomania\CoreBundle\Entity\Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set person
     *
     * @param \Zenomania\CoreBundle\Entity\Person $person
     *
     * @return EventAttendanceImport
     */
    public function setPerson(\Zenomania\CoreBundle\Entity\Person $person = null)
    {
        $this->person = $person;

        return $this;
    }

    /**
     * Get person
     *
     * @return \Zenomania\CoreBundle\Entity\Person
     */
    public function getPerson()
    {
        return $this->person;
    }
}
