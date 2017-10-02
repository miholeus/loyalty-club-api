<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * Subscription
 */
class Subscription
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $mifare;

    /**
     * @var string
     */
    private $serial;

    /**
     * @var string
     */
    private $number;

    /**
     * @var string
     */
    private $stand;

    /**
     * @var string
     */
    private $sector;

    /**
     * @var string
     */
    private $row;

    /**
     * @var string
     */
    private $seat;

    /**
     * @var string
     */
    private $price;

    /**
     * @var string
     */
    private $note = '';

    /**
     * @var \Zenomania\CoreBundle\Entity\Person
     */
    private $person;

    /**
     * @var \Zenomania\CoreBundle\Entity\Season
     */
    private $season;

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
     * Set mifare
     *
     * @param string $mifare
     *
     * @return Subscription
     */
    public function setMifare($mifare)
    {
        $this->mifare = $mifare;

        return $this;
    }

    /**
     * Get mifare
     *
     * @return string
     */
    public function getMifare()
    {
        return $this->mifare;
    }

    /**
     * Set serial
     *
     * @param string $serial
     *
     * @return Subscription
     */
    public function setSerial($serial)
    {
        $this->serial = $serial;

        return $this;
    }

    /**
     * Get serial
     *
     * @return string
     */
    public function getSerial()
    {
        return $this->serial;
    }

    /**
     * Set number
     *
     * @param string $number
     *
     * @return Subscription
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set stand
     *
     * @param string $stand
     *
     * @return Subscription
     */
    public function setStand($stand)
    {
        $this->stand = $stand;

        return $this;
    }

    /**
     * Get stand
     *
     * @return string
     */
    public function getStand()
    {
        return $this->stand;
    }

    /**
     * Set sector
     *
     * @param string $sector
     *
     * @return Subscription
     */
    public function setSector($sector)
    {
        $this->sector = $sector;

        return $this;
    }

    /**
     * Get sector
     *
     * @return string
     */
    public function getSector()
    {
        return $this->sector;
    }

    /**
     * Set row
     *
     * @param string $row
     *
     * @return Subscription
     */
    public function setRow($row)
    {
        $this->row = $row;

        return $this;
    }

    /**
     * Get row
     *
     * @return string
     */
    public function getRow()
    {
        return $this->row;
    }

    /**
     * Set seat
     *
     * @param string $seat
     *
     * @return Subscription
     */
    public function setSeat($seat)
    {
        $this->seat = $seat;

        return $this;
    }

    /**
     * Get seat
     *
     * @return string
     */
    public function getSeat()
    {
        return $this->seat;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Subscription
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set note
     *
     * @param string $note
     *
     * @return Subscription
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set person
     *
     * @param \Zenomania\CoreBundle\Entity\Person $person
     *
     * @return Subscription
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
     * Set season
     *
     * @param \Zenomania\CoreBundle\Entity\Season $season
     *
     * @return Subscription
     */
    public function setSeason(\Zenomania\CoreBundle\Entity\Season $season = null)
    {
        $this->season = $season;

        return $this;
    }

    /**
     * Get season
     *
     * @return \Zenomania\CoreBundle\Entity\Season
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * Add personPoint
     *
     * @param \Zenomania\CoreBundle\Entity\PersonPoints $personPoint
     *
     * @return Subscription
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
