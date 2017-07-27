<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * Video
 */
class Video
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $depiction;

    /**
     * @var string
     */
    private $file;

    /**
     * @var string
     */
    private $img = '/static/img/video.jpg';

    /**
     * @var string
     */
    private $viewCond;

    /**
     * @var \DateTime
     */
    private $dt;

    /**
     * @var integer
     */
    private $actorId;

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
     * @return Video
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
     * Set depiction
     *
     * @param string $depiction
     *
     * @return Video
     */
    public function setDepiction($depiction)
    {
        $this->depiction = $depiction;

        return $this;
    }

    /**
     * Get depiction
     *
     * @return string
     */
    public function getDepiction()
    {
        return $this->depiction;
    }

    /**
     * Set file
     *
     * @param string $file
     *
     * @return Video
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set img
     *
     * @param string $img
     *
     * @return Video
     */
    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }

    /**
     * Get img
     *
     * @return string
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * Set viewCond
     *
     * @param string $viewCond
     *
     * @return Video
     */
    public function setViewCond($viewCond)
    {
        $this->viewCond = $viewCond;

        return $this;
    }

    /**
     * Get viewCond
     *
     * @return string
     */
    public function getViewCond()
    {
        return $this->viewCond;
    }

    /**
     * Set dt
     *
     * @param \DateTime $dt
     *
     * @return Video
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
     * Set actorId
     *
     * @param integer $actorId
     *
     * @return Video
     */
    public function setActorId($actorId)
    {
        $this->actorId = $actorId;

        return $this;
    }

    /**
     * Get actorId
     *
     * @return integer
     */
    public function getActorId()
    {
        return $this->actorId;
    }

    /**
     * Add person
     *
     * @param \Zenomania\CoreBundle\Entity\Person $person
     *
     * @return Video
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

