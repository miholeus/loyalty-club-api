<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * Player
 */
class Player
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name = 'нет';

    /**
     * @var boolean
     */
    private $active = '0';

    /**
     * @var \DateTime
     */
    private $bdate;

    /**
     * @var \Zenomania\CoreBundle\Entity\Club
     */
    private $club;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $person;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->person = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Player
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
     * Set active
     *
     * @param boolean $active
     *
     * @return Player
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set bdate
     *
     * @param \DateTime $bdate
     *
     * @return Player
     */
    public function setBdate($bdate)
    {
        $this->bdate = $bdate;

        return $this;
    }

    /**
     * Get bdate
     *
     * @return \DateTime
     */
    public function getBdate()
    {
        return $this->bdate;
    }

    /**
     * Set club
     *
     * @param \Zenomania\CoreBundle\Entity\Club $club
     *
     * @return Player
     */
    public function setClub(\Zenomania\CoreBundle\Entity\Club $club = null)
    {
        $this->club = $club;

        return $this;
    }

    /**
     * Get club
     *
     * @return \Zenomania\CoreBundle\Entity\Club
     */
    public function getClub()
    {
        return $this->club;
    }

    /**
     * Add person
     *
     * @param \Zenomania\CoreBundle\Entity\Person $person
     *
     * @return Player
     */
    public function addPerson(\Zenomania\CoreBundle\Entity\Person $person)
    {
        $this->person[] = $person;

        return $this;
    }

    /**
     * Remove person
     *
     * @param \Zenomania\CoreBundle\Entity\Person $person
     */
    public function removePerson(\Zenomania\CoreBundle\Entity\Person $person)
    {
        $this->person->removeElement($person);
    }

    /**
     * Get person
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPerson()
    {
        return $this->person;
    }
}

