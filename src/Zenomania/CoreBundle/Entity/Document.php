<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * Document
 */
class Document
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $personId = '0';

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $serial = '0';

    /**
     * @var string
     */
    private $number = '0';

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $subCode = '0';

    /**
     * @var string
     */
    private $given = '0';


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
     * Set personId
     *
     * @param integer $personId
     *
     * @return Document
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
     * Set type
     *
     * @param string $type
     *
     * @return Document
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
     * Set serial
     *
     * @param string $serial
     *
     * @return Document
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
     * @return Document
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Document
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set subCode
     *
     * @param string $subCode
     *
     * @return Document
     */
    public function setSubCode($subCode)
    {
        $this->subCode = $subCode;

        return $this;
    }

    /**
     * Get subCode
     *
     * @return string
     */
    public function getSubCode()
    {
        return $this->subCode;
    }

    /**
     * Set given
     *
     * @param string $given
     *
     * @return Document
     */
    public function setGiven($given)
    {
        $this->given = $given;

        return $this;
    }

    /**
     * Get given
     *
     * @return string
     */
    public function getGiven()
    {
        return $this->given;
    }
}

