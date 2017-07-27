<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * PromoSmsIn
 */
class PromoSmsIn
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $frommobile;

    /**
     * @var string
     */
    private $tomobile;

    /**
     * @var string
     */
    private $outerid;

    /**
     * @var \DateTime
     */
    private $datetime;

    /**
     * @var string
     */
    private $prefix;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $special = 'NONE';

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
     * Set frommobile
     *
     * @param string $frommobile
     *
     * @return PromoSmsIn
     */
    public function setFrommobile($frommobile)
    {
        $this->frommobile = $frommobile;

        return $this;
    }

    /**
     * Get frommobile
     *
     * @return string
     */
    public function getFrommobile()
    {
        return $this->frommobile;
    }

    /**
     * Set tomobile
     *
     * @param string $tomobile
     *
     * @return PromoSmsIn
     */
    public function setTomobile($tomobile)
    {
        $this->tomobile = $tomobile;

        return $this;
    }

    /**
     * Get tomobile
     *
     * @return string
     */
    public function getTomobile()
    {
        return $this->tomobile;
    }

    /**
     * Set outerid
     *
     * @param string $outerid
     *
     * @return PromoSmsIn
     */
    public function setOuterid($outerid)
    {
        $this->outerid = $outerid;

        return $this;
    }

    /**
     * Get outerid
     *
     * @return string
     */
    public function getOuterid()
    {
        return $this->outerid;
    }

    /**
     * Set datetime
     *
     * @param \DateTime $datetime
     *
     * @return PromoSmsIn
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * Get datetime
     *
     * @return \DateTime
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * Set prefix
     *
     * @param string $prefix
     *
     * @return PromoSmsIn
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Get prefix
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return PromoSmsIn
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set special
     *
     * @param string $special
     *
     * @return PromoSmsIn
     */
    public function setSpecial($special)
    {
        $this->special = $special;

        return $this;
    }

    /**
     * Get special
     *
     * @return string
     */
    public function getSpecial()
    {
        return $this->special;
    }

    /**
     * Set person
     *
     * @param \Zenomania\CoreBundle\Entity\Person $person
     *
     * @return PromoSmsIn
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

