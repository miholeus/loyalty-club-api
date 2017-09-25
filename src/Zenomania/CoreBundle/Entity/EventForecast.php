<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * PersonEventForecast
 */
class EventForecast
{
    const STATUS_NEW = 1;
    const STATUS_PROCESSED = 2;
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
    private $createdOn;

    /**
     * @var \DateTime
     */
    private $updatedOn;

    /**
     * @var \Zenomania\CoreBundle\Entity\Event
     */
    private $event;

    /**
     * @var \Zenomania\CoreBundle\Entity\Person
     */
    private $person;

    /**
     * @var string
     */
    private $scoreInRounds;

    /**
     * @var \Zenomania\CoreBundle\Entity\User
     */
    private $user;

    /**
     * @var integer
     */
    private $status;

    public function __construct()
    {
        $this->createdOn = new \DateTime();
        $this->updatedOn = new \DateTime();
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
     * Set scoreHome
     *
     * @param integer $scoreHome
     *
     * @return EventForecast
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
     * @return EventForecast
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
     * @param \DateTime $createdOn
     *
     * @return EventForecast
     */
    public function setCreatedOn(\DateTime $createdOn)
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    /**
     * Get dt
     *
     * @return \DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * Set event
     *
     * @param \Zenomania\CoreBundle\Entity\Event $event
     *
     * @return EventForecast
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
     * @return EventForecast
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

    /**
     * Set user
     *
     * @param \Zenomania\CoreBundle\Entity\User $user
     *
     * @return EventForecast
     */
    public function setUser(\Zenomania\CoreBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Zenomania\CoreBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set scoreInRounds
     *
     * @param string $scoreInRounds
     *
     * @return EventForecast
     */
    public function setScoreInRounds($scoreInRounds)
    {
        $this->scoreInRounds = $scoreInRounds;

        return $this;
    }

    /**
     * Get scoreInRounds
     *
     * @return string
     */
    public function getScoreInRounds()
    {
        return $this->scoreInRounds;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return EventForecast
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }

    /**
     * @param \DateTime $updatedOn
     */
    public function setUpdatedOn(\DateTime $updatedOn)
    {
        $this->updatedOn = $updatedOn;
    }
}
