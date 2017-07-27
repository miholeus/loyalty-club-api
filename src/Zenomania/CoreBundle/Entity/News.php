<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * News
 */
class News
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $text;

    /**
     * @var boolean
     */
    private $hide;

    /**
     * @var \DateTime
     */
    private $dt;

    /**
     * @var \DateTime
     */
    private $dtStart;

    /**
     * @var \DateTime
     */
    private $dtEnd;

    /**
     * @var integer
     */
    private $actorId;


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
     * Set text
     *
     * @param string $text
     *
     * @return News
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set hide
     *
     * @param boolean $hide
     *
     * @return News
     */
    public function setHide($hide)
    {
        $this->hide = $hide;

        return $this;
    }

    /**
     * Get hide
     *
     * @return boolean
     */
    public function getHide()
    {
        return $this->hide;
    }

    /**
     * Set dt
     *
     * @param \DateTime $dt
     *
     * @return News
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
     * Set dtStart
     *
     * @param \DateTime $dtStart
     *
     * @return News
     */
    public function setDtStart($dtStart)
    {
        $this->dtStart = $dtStart;

        return $this;
    }

    /**
     * Get dtStart
     *
     * @return \DateTime
     */
    public function getDtStart()
    {
        return $this->dtStart;
    }

    /**
     * Set dtEnd
     *
     * @param \DateTime $dtEnd
     *
     * @return News
     */
    public function setDtEnd($dtEnd)
    {
        $this->dtEnd = $dtEnd;

        return $this;
    }

    /**
     * Get dtEnd
     *
     * @return \DateTime
     */
    public function getDtEnd()
    {
        return $this->dtEnd;
    }

    /**
     * Set actorId
     *
     * @param integer $actorId
     *
     * @return News
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
}
