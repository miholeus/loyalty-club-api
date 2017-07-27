<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * PersonEventForecast
 */
class PersonEventForecast
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $scoreHome;

    /**
     * @var integer
     */
    private $scoreGuest;

    /**
     * @var \DateTime
     */
    private $dt;

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
     * Set scoreHome
     *
     * @param integer $scoreHome
     *
     * @return PersonEventForecast
     */
    public function setScoreHome($scoreHome)
    {
        $this->scoreHome = $scoreHome;

        return $this;
    }

    /**
     * Get scoreHome
     *
     * @return integer
     */
    public function getScoreHome()
    {
        return $this->scoreHome;
    }

    /**
     * Set scoreGuest
     *
     * @param integer $scoreGuest
     *
     * @return PersonEventForecast
     */
    public function setScoreGuest($scoreGuest)
    {
        $this->scoreGuest = $scoreGuest;

        return $this;
    }

    /**
     * Get scoreGuest
     *
     * @return integer
     */
    public function getScoreGuest()
    {
        return $this->scoreGuest;
    }

    /**
     * Set dt
     *
     * @param \DateTime $dt
     *
     * @return PersonEventForecast
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
     * Set event
     *
     * @param \Zenomania\CoreBundle\Entity\Event $event
     *
     * @return PersonEventForecast
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
     * @return PersonEventForecast
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
