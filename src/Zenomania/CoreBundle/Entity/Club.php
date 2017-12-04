<?php

namespace Zenomania\CoreBundle\Entity;

use Zenomania\CoreBundle\Service\Upload\IdentifiableInterface;

/**
 * Club
 */
class Club implements IdentifiableInterface
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
    private $site;

    /**
     * @var string
     */
    private $logoImg;

    /**
     * @var \Zenomania\CoreBundle\Entity\Sport
     */
    private $sport;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $players;
    /**
     * @var boolean
     */
    private $lineUpAvailable = false;

    /**
     * @var int|null
     */
    private $externalId;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->players = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Club
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
     * Set site
     *
     * @param string $site
     *
     * @return Club
     */
    public function setSite($site)
    {
        $this->site = $site;

        return $this;
    }

    /**
     * Get site
     *
     * @return string
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Set logoImg
     *
     * @param string $logoImg
     *
     * @return Club
     */
    public function setLogoImg($logoImg)
    {
        $this->logoImg = $logoImg;

        return $this;
    }

    /**
     * Get logoImg
     *
     * @return string
     */
    public function getLogoImg()
    {
        return $this->logoImg;
    }

    /**
     * Set sport
     *
     * @param \Zenomania\CoreBundle\Entity\Sport $sport
     *
     * @return Club
     */
    public function setSport(\Zenomania\CoreBundle\Entity\Sport $sport = null)
    {
        $this->sport = $sport;

        return $this;
    }

    /**
     * Get sport
     *
     * @return \Zenomania\CoreBundle\Entity\Sport
     */
    public function getSport()
    {
        return $this->sport;
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * Set lineUpAvailable
     *
     * @param boolean $lineUpAvailable
     *
     * @return Club
     */
    public function setLineUpAvailable($lineUpAvailable)
    {
        $this->lineUpAvailable = $lineUpAvailable;

        return $this;
    }

    /**
     * Get lineUpAvailable
     *
     * @return boolean
     */
    public function getLineUpAvailable()
    {
        return $this->lineUpAvailable;
    }

    /**
     * Add player
     *
     * @param \Zenomania\CoreBundle\Entity\Player $player
     *
     * @return Club
     */
    public function addPlayer(\Zenomania\CoreBundle\Entity\Player $player)
    {
        $this->players[] = $player;

        return $this;
    }

    /**
     * Remove player
     *
     * @param \Zenomania\CoreBundle\Entity\Player $player
     */
    public function removePlayer(\Zenomania\CoreBundle\Entity\Player $player)
    {
        $this->players->removeElement($player);
    }

    /**
     * Get players
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * Set externalId.
     *
     * @param int|null $externalId
     *
     * @return Club
     */
    public function setExternalId($externalId = null)
    {
        $this->externalId = $externalId;

        return $this;
    }

    /**
     * Get externalId.
     *
     * @return int|null
     */
    public function getExternalId()
    {
        return $this->externalId;
    }
}
