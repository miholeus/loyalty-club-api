<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * PersonPoints
 */
class PersonPoints
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $points = '0';

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $state = 'none';

    /**
     * @var \DateTime
     */
    private $dt;

    /**
     * @var \Zenomania\CoreBundle\Entity\PromoAction
     */
    private $season;

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
     * Set points
     *
     * @param integer $points
     *
     * @return PersonPoints
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
     * Set type
     *
     * @param string $type
     *
     * @return PersonPoints
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set state
     *
     * @param string $state
     *
     * @return PersonPoints
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set dt
     *
     * @param \DateTime $dt
     *
     * @return PersonPoints
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
     * Set season
     *
     * @param \Zenomania\CoreBundle\Entity\PromoAction $season
     *
     * @return PersonPoints
     */
    public function setSeason(\Zenomania\CoreBundle\Entity\PromoAction $season = null)
    {
        $this->season = $season;

        return $this;
    }

    /**
     * Get season
     *
     * @return \Zenomania\CoreBundle\Entity\PromoAction
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * Set person
     *
     * @param \Zenomania\CoreBundle\Entity\Person $person
     *
     * @return PersonPoints
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

