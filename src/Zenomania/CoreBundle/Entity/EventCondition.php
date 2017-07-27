<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * EventCondition
 */
class EventCondition
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var boolean
     */
    private $temperature;

    /**
     * @var string
     */
    private $weather;

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
     * Set temperature
     *
     * @param boolean $temperature
     *
     * @return EventCondition
     */
    public function setTemperature($temperature)
    {
        $this->temperature = $temperature;

        return $this;
    }

    /**
     * Get temperature
     *
     * @return boolean
     */
    public function getTemperature()
    {
        return $this->temperature;
    }

    /**
     * Set weather
     *
     * @param string $weather
     *
     * @return EventCondition
     */
    public function setWeather($weather)
    {
        $this->weather = $weather;

        return $this;
    }

    /**
     * Get weather
     *
     * @return string
     */
    public function getWeather()
    {
        return $this->weather;
    }

    /**
     * Set event
     *
     * @param \Zenomania\CoreBundle\Entity\Event $event
     *
     * @return EventCondition
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

