<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * Sport
 */
class Sport
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name = '0';

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
     * @return Sport
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
     * Add person
     *
     * @param \Zenomania\CoreBundle\Entity\Person $person
     *
     * @return Sport
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
