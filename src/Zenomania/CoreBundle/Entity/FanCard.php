<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * FanCard
 */
class FanCard
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $number = '0';

    /**
     * @var string
     */
    private $innerNumber = '0';

    /**
     * @var string
     */
    private $state = 'Active';

    /**
     * @var \DateTime
     */
    private $bestBeforeDate;

    /**
     * @var string
     */
    private $spentSum = '0.00';

    /**
     * @var string
     */
    private $points = '0.00';

    /**
     * @var \DateTime
     */
    private $givenDate;

    /**
     * @var string
     */
    private $blockedReason;

    /**
     * @var string
     */
    private $blockedReasonComment;

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
     * Set number
     *
     * @param string $number
     *
     * @return FanCard
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
     * Set innerNumber
     *
     * @param string $innerNumber
     *
     * @return FanCard
     */
    public function setInnerNumber($innerNumber)
    {
        $this->innerNumber = $innerNumber;

        return $this;
    }

    /**
     * Get innerNumber
     *
     * @return string
     */
    public function getInnerNumber()
    {
        return $this->innerNumber;
    }

    /**
     * Set state
     *
     * @param string $state
     *
     * @return FanCard
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
     * Set bestBeforeDate
     *
     * @param \DateTime $bestBeforeDate
     *
     * @return FanCard
     */
    public function setBestBeforeDate($bestBeforeDate)
    {
        $this->bestBeforeDate = $bestBeforeDate;

        return $this;
    }

    /**
     * Get bestBeforeDate
     *
     * @return \DateTime
     */
    public function getBestBeforeDate()
    {
        return $this->bestBeforeDate;
    }

    /**
     * Set spentSum
     *
     * @param string $spentSum
     *
     * @return FanCard
     */
    public function setSpentSum($spentSum)
    {
        $this->spentSum = $spentSum;

        return $this;
    }

    /**
     * Get spentSum
     *
     * @return string
     */
    public function getSpentSum()
    {
        return $this->spentSum;
    }

    /**
     * Set points
     *
     * @param string $points
     *
     * @return FanCard
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get points
     *
     * @return string
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Set givenDate
     *
     * @param \DateTime $givenDate
     *
     * @return FanCard
     */
    public function setGivenDate($givenDate)
    {
        $this->givenDate = $givenDate;

        return $this;
    }

    /**
     * Get givenDate
     *
     * @return \DateTime
     */
    public function getGivenDate()
    {
        return $this->givenDate;
    }

    /**
     * Set blockedReason
     *
     * @param string $blockedReason
     *
     * @return FanCard
     */
    public function setBlockedReason($blockedReason)
    {
        $this->blockedReason = $blockedReason;

        return $this;
    }

    /**
     * Get blockedReason
     *
     * @return string
     */
    public function getBlockedReason()
    {
        return $this->blockedReason;
    }

    /**
     * Set blockedReasonComment
     *
     * @param string $blockedReasonComment
     *
     * @return FanCard
     */
    public function setBlockedReasonComment($blockedReasonComment)
    {
        $this->blockedReasonComment = $blockedReasonComment;

        return $this;
    }

    /**
     * Get blockedReasonComment
     *
     * @return string
     */
    public function getBlockedReasonComment()
    {
        return $this->blockedReasonComment;
    }

    /**
     * Add person
     *
     * @param \Zenomania\CoreBundle\Entity\Person $person
     *
     * @return FanCard
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
