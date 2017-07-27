<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * GiveawayAction
 */
class GiveawayAction
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name = 'Free zens to everyone';

    /**
     * @var string
     */
    private $occasion = '';

    /**
     * @var \DateTime
     */
    private $dt;

    /**
     * @var integer
     */
    private $points;

    /**
     * @var boolean
     */
    private $progress;

    /**
     * @var \Zenomania\CoreBundle\Entity\Actor
     */
    private $actor;

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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return GiveawayAction
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set occasion
     *
     * @param string $occasion
     *
     * @return GiveawayAction
     */
    public function setOccasion($occasion)
    {
        $this->occasion = $occasion;

        return $this;
    }

    /**
     * Get occasion
     *
     * @return string
     */
    public function getOccasion()
    {
        return $this->occasion;
    }

    /**
     * Set dt
     *
     * @param \DateTime $dt
     *
     * @return GiveawayAction
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
     * Set points
     *
     * @param integer $points
     *
     * @return GiveawayAction
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get points
     *
     * @return integer
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Set progress
     *
     * @param boolean $progress
     *
     * @return GiveawayAction
     */
    public function setProgress($progress)
    {
        $this->progress = $progress;

        return $this;
    }

    /**
     * Get progress
     *
     * @return boolean
     */
    public function getProgress()
    {
        return $this->progress;
    }

    /**
     * Set actor
     *
     * @param \Zenomania\CoreBundle\Entity\Actor $actor
     *
     * @return GiveawayAction
     */
    public function setActor(\Zenomania\CoreBundle\Entity\Actor $actor = null)
    {
        $this->actor = $actor;

        return $this;
    }

    /**
     * Get actor
     *
     * @return \Zenomania\CoreBundle\Entity\Actor
     */
    public function getActor()
    {
        return $this->actor;
    }

    /**
     * Add personPoint
     *
     * @param \Zenomania\CoreBundle\Entity\PersonPoints $personPoint
     *
     * @return GiveawayAction
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

