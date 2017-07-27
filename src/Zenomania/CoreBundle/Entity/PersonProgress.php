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

    /**
     * @var \Zenomania\CoreBundle\Entity\ProgressItems
     */
    private $progress;


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
     * Set progress
     *
     * @param \Zenomania\CoreBundle\Entity\ProgressItems $progress
     *
     * @return PersonProgress
     */
    public function setProgress(\Zenomania\CoreBundle\Entity\ProgressItems $progress = null)
    {
        $this->progress = $progress;

        return $this;
    }

    /**
     * Get progress
     *
     * @return \Zenomania\CoreBundle\Entity\ProgressItems
     */
    public function getProgress()
    {
        return $this->progress;
    }
}
