<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * EventAttendanceTicket
 */
class EventAttendanceTicket
{
    /**
     * @var integer
     */
    private $id = '0';

    /**
     * @var string
     */
    private $mobile;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $barcode;

    /**
     * @var \DateTime
     */
    private $dt;

    /**
     * @var boolean
     */
    private $noProcess = '0';

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
     * Set mobile
     *
     * @param string $mobile
     *
     * @return EventAttendanceTicket
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Get mobile
     *
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return EventAttendanceTicket
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return EventAttendanceTicket
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set barcode
     *
     * @param string $barcode
     *
     * @return EventAttendanceTicket
     */
    public function setBarcode($barcode)
    {
        $this->barcode = $barcode;

        return $this;
    }

    /**
     * Get barcode
     *
     * @return string
     */
    public function getBarcode()
    {
        return $this->barcode;
    }

    /**
     * Set dt
     *
     * @param \DateTime $dt
     *
     * @return EventAttendanceTicket
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
     * Set noProcess
     *
     * @param boolean $noProcess
     *
     * @return EventAttendanceTicket
     */
    public function setNoProcess($noProcess)
    {
        $this->noProcess = $noProcess;

        return $this;
    }

    /**
     * Get noProcess
     *
     * @return boolean
     */
    public function getNoProcess()
    {
        return $this->noProcess;
    }

    /**
     * Set person
     *
     * @param \Zenomania\CoreBundle\Entity\Person $person
     *
     * @return EventAttendanceTicket
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

