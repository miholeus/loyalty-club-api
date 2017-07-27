<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * PromoAction
 */
class PromoAction
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
    private $displayname;

    /**
     * @var boolean
     */
    private $active = '0';

    /**
     * @var \DateTime
     */
    private $dtStart;

    /**
     * @var \DateTime
     */
    private $dtEnd;

    /**
     * @var \Zenomania\CoreBundle\Entity\Club
     */
    private $clubOwner;


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
     * @return PromoAction
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
     * Set displayname
     *
     * @param string $displayname
     *
     * @return PromoAction
     */
    public function setDisplayname($displayname)
    {
        $this->displayname = $displayname;

        return $this;
    }

    /**
     * Get displayname
     *
     * @return string
     */
    public function getDisplayname()
    {
        return $this->displayname;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return PromoAction
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
     * Set dtStart
     *
     * @param \DateTime $dtStart
     *
     * @return PromoAction
     */
    public function setDtStart($dtStart)
    {
        $this->dtStart = $dtStart;

        return $this;
    }

    /**
     * Get dtStart
     *
     * @return \DateTime
     */
    public function getDtStart()
    {
        return $this->dtStart;
    }

    /**
     * Set dtEnd
     *
     * @param \DateTime $dtEnd
     *
     * @return PromoAction
     */
    public function setDtEnd($dtEnd)
    {
        $this->dtEnd = $dtEnd;

        return $this;
    }

    /**
     * Get dtEnd
     *
     * @return \DateTime
     */
    public function getDtEnd()
    {
        return $this->dtEnd;
    }

    /**
     * Set clubOwner
     *
     * @param \Zenomania\CoreBundle\Entity\Club $clubOwner
     *
     * @return PromoAction
     */
    public function setClubOwner(\Zenomania\CoreBundle\Entity\Club $clubOwner = null)
    {
        $this->clubOwner = $clubOwner;

        return $this;
    }

    /**
     * Get clubOwner
     *
     * @return \Zenomania\CoreBundle\Entity\Club
     */
    public function getClubOwner()
    {
        return $this->clubOwner;
    }
}
