<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * PersonProgress
 */
class PersonProgress
{
    /**
     * @var integer
     */
    private $personId;

    /**
     * @var \DateTime
     */
    private $dt;


    public function __construct(Person $person, ProgressItems $progress)
    {
        $this->personId = $person->getId();
        $this->progressId = $progress->getId();
    }
    /**
     * Set personId
     *
     * @param integer $personId
     *
     * @return PersonProgress
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
     * @return PersonProgress
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
     * @var integer
     */
    private $progressId;

    /**
     * Get progressId
     *
     * @return integer
     */
    public function getProgressId()
    {
        return $this->progressId;
    }

    /**
     * Set progressId
     *
     * @param integer $progressId
     *
     * @return PersonProgress
     */
    public function setProgressId($progressId)
    {
        $this->progressId = $progressId;

        return $this;
    }
}
