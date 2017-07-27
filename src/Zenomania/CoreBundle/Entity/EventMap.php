<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * EventMap
 */
class EventMap
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $outerId;

    /**
     * @var boolean
     */
    private $use4promo = '0';

    /**
     * @var \Zenomania\CoreBundle\Entity\ClientApplication
     */
    private $app;

    /**
     * @var \Zenomania\CoreBundle\Entity\Event
     */
    private $event;


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
     * Set outerId
     *
     * @param integer $outerId
     *
     * @return EventMap
     */
    public function setOuterId($outerId)
    {
        $this->outerId = $outerId;

        return $this;
    }

    /**
     * Get outerId
     *
     * @return integer
     */
    public function getOuterId()
    {
        return $this->outerId;
    }

    /**
     * Set use4promo
     *
     * @param boolean $use4promo
     *
     * @return EventMap
     */
    public function setUse4promo($use4promo)
    {
        $this->use4promo = $use4promo;

        return $this;
    }

    /**
     * Get use4promo
     *
     * @return boolean
     */
    public function getUse4promo()
    {
        return $this->use4promo;
    }

    /**
     * Set app
     *
     * @param \Zenomania\CoreBundle\Entity\ClientApplication $app
     *
     * @return EventMap
     */
    public function setApp(\Zenomania\CoreBundle\Entity\ClientApplication $app = null)
    {
        $this->app = $app;

        return $this;
    }

    /**
     * Get app
     *
     * @return \Zenomania\CoreBundle\Entity\ClientApplication
     */
    public function getApp()
    {
        return $this->app;
    }

    /**
     * Set event
     *
     * @param \Zenomania\CoreBundle\Entity\Event $event
     *
     * @return EventMap
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
}

