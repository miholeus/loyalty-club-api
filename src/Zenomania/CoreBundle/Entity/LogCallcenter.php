<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * LogCallcenter
 */
class LogCallcenter
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $actorId = '0';

    /**
     * @var integer
     */
    private $personId = '0';

    /**
     * @var \DateTime
     */
    private $dt;

    /**
     * @var string
     */
    private $old;

    /**
     * @var string
     */
    private $new;


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
     * Set actorId
     *
     * @param integer $actorId
     *
     * @return LogCallcenter
     */
    public function setActorId($actorId)
    {
        $this->actorId = $actorId;

        return $this;
    }

    /**
     * Get actorId
     *
     * @return integer
     */
    public function getActorId()
    {
        return $this->actorId;
    }

    /**
     * Set personId
     *
     * @param integer $personId
     *
     * @return LogCallcenter
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
     * Set dt
     *
     * @param \DateTime $dt
     *
     * @return LogCallcenter
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
     * Set old
     *
     * @param string $old
     *
     * @return LogCallcenter
     */
    public function setOld($old)
    {
        $this->old = $old;

        return $this;
    }

    /**
     * Get old
     *
     * @return string
     */
    public function getOld()
    {
        return $this->old;
    }

    /**
     * Set new
     *
     * @param string $new
     *
     * @return LogCallcenter
     */
    public function setNew($new)
    {
        $this->new = $new;

        return $this;
    }

    /**
     * Get new
     *
     * @return string
     */
    public function getNew()
    {
        return $this->new;
    }
}

