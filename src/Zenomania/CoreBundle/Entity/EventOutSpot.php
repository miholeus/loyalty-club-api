<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * EventOutSpot
 */
class EventOutSpot
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
     * @var boolean
     */
    private $reserved = '0';

    /**
     * @var \Zenomania\CoreBundle\Entity\Event
     */
    private $event;

    /**
     * @var \Zenomania\CoreBundle\Entity\PersonPurchase
     */
    private $purchase;


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
     * @return EventOutSpot
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
     * Set reserved
     *
     * @param boolean $reserved
     *
     * @return EventOutSpot
     */
    public function setReserved($reserved)
    {
        $this->reserved = $reserved;

        return $this;
    }

    /**
     * Get reserved
     *
     * @return boolean
     */
    public function getReserved()
    {
        return $this->reserved;
    }

    /**
     * Set event
     *
     * @param \Zenomania\CoreBundle\Entity\Event $event
     *
     * @return EventOutSpot
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
     * Set purchase
     *
     * @param \Zenomania\CoreBundle\Entity\PersonPurchase $purchase
     *
     * @return EventOutSpot
     */
    public function setPurchase(\Zenomania\CoreBundle\Entity\PersonPurchase $purchase = null)
    {
        $this->purchase = $purchase;

        return $this;
    }

    /**
     * Get purchase
     *
     * @return \Zenomania\CoreBundle\Entity\PersonPurchase
     */
    public function getPurchase()
    {
        return $this->purchase;
    }
}
