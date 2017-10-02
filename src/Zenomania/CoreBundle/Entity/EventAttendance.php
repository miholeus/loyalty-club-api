<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * EventAttendance
 */
class EventAttendance
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $ticketId;

    /**
     * @var integer
     */
    private $subscriptionId;

    /**
     * @var \DateTime
     */
    private $enterDate;

    /**
     * @var \Zenomania\CoreBundle\Entity\Event
     */
    private $event;

    /**
     * @var \Zenomania\CoreBundle\Entity\Person
     */
    private $person;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $personPoint;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->personPoint = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @param array $data
     * @return EventAttendance
     */
    public static function fromArray(array $data) : EventAttendance
    {
        $self = new self();
        foreach ($data as $key => $value) {
            $self->{"set".ucfirst($key)}($value);
        }
        return $self;
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
     * Set ticketId
     *
     * @param integer $ticketId
     *
     * @return EventAttendance
     */
    public function setTicketId($ticketId)
    {
        $this->ticketId = $ticketId;

        return $this;
    }

    /**
     * Get ticketId
     *
     * @return integer
     */
    public function getTicketId()
    {
        return $this->ticketId;
    }

    /**
     * Set subscriptionId
     *
     * @param integer $subscriptionId
     *
     * @return EventAttendance
     */
    public function setSubscriptionId($subscriptionId)
    {
        $this->subscriptionId = $subscriptionId;

        return $this;
    }

    /**
     * Get subscriptionId
     *
     * @return integer
     */
    public function getSubscriptionId()
    {
        return $this->subscriptionId;
    }

    /**
     * Set enterDate
     *
     * @param \DateTime $enterDate
     *
     * @return EventAttendance
     */
    public function setEnterDate($enterDate)
    {
        $this->enterDate = $enterDate;

        return $this;
    }

    /**
     * Get enterDate
     *
     * @return \DateTime
     */
    public function getEnterDate()
    {
        return $this->enterDate;
    }

    /**
     * Set event
     *
     * @param \Zenomania\CoreBundle\Entity\Event $event
     *
     * @return EventAttendance
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
     * @return EventAttendance
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
     * Add personPoint
     *
     * @param \Zenomania\CoreBundle\Entity\PersonPoints $personPoint
     *
     * @return EventAttendance
     */
    public function addPersonPoint(\Zenomania\CoreBundle\Entity\PersonPoints $personPoint)
    {
        $this->personPoint[] = $personPoint;

        return $this;
    }

    /**
     * Remove personPoint
     *
     * @param \Zenomania\CoreBundle\Entity\PersonPoints $personPoint
     */
    public function removePersonPoint(\Zenomania\CoreBundle\Entity\PersonPoints $personPoint)
    {
        $this->personPoint->removeElement($personPoint);
    }

    /**
     * Get personPoint
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPersonPoint()
    {
        return $this->personPoint;
    }
}
