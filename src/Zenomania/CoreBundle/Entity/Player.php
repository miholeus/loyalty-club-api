<?php

namespace Zenomania\CoreBundle\Entity;

use Zenomania\CoreBundle\Service\Upload\IdentifiableInterface;

/**
 * Player
 */
class Player implements IdentifiableInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $firstname;

    /**
     * @var string
     */
    private $lastname;

    /**
     * @var string
     */
    private $middlename;

    /**
     * @var \DateTime
     */
    private $birthdate;

    /**
     * @var \Zenomania\CoreBundle\Entity\Club
     */
    private $club;

    /**
     * @var string
     */
    private $photo;

    /**
     * @var \DateTime
     */
    private $createdOn;

    /**
     * @var \DateTime
     */
    private $updatedOn;

    /**
     * @var boolean
     */
    private $isActive;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function __toString()
    {
        return sprintf("%s %s", $this->getFirstname(), $this->getLastname());
    }

    public function __construct()
    {
        $this->createdOn = new \DateTime();
        $this->updatedOn = new \DateTime();
    }

    /**
     * Set birthdate
     *
     * @param \DateTime $birthdate
     *
     * @return Player
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime
     */
    public function getBirthdate()
    {
        return $this->birthdate;
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
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     *
     * @return Player
     */
    public function setFirstname(string $firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     *
     * @return Player
     */
    public function setLastname(string $lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return string
     */
    public function getMiddlename()
    {
        return $this->middlename;
    }

    /**
     * @param string $middlename
     *
     * @return Player
     */
    public function setMiddlename(string $middlename)
    {
        $this->middlename = $middlename;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param string $photo
     *
     * @return Player
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @param \DateTime $createdOn
     *
     * @return Player
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;

        return $this;
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
     *
     * @return Player
     */
    public function setUpdatedOn($updatedOn)
    {
        $this->updatedOn = $updatedOn;

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     *
     * @return Player
     */
    public function setIsActive(bool $isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

}
