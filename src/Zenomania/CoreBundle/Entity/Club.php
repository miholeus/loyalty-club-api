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
    private $vkGroup = '';

    /**
     * @var string
     */
    private $fbGroup = '';

    /**
     * @var string
     */
    private $twitterGroup = '';

    /**
     * @var string
     */
    private $instagramGroup = '';

    /**
     * @var string
     */
    private $youtubeGroup = '';

    /**
     * @var string
     */
    private $ytUploadPlaylist = '';

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
     * Set vkGroup
     *
     * @param string $vkGroup
     *
     * @return Club
     */
    public function setVkGroup($vkGroup)
    {
        $this->vkGroup = $vkGroup;

        return $this;
    }

    /**
     * Get vkGroup
     *
     * @return string
     */
    public function getVkGroup()
    {
        return $this->vkGroup;
    }

    /**
     * Set fbGroup
     *
     * @param string $fbGroup
     *
     * @return Club
     */
    public function setFbGroup($fbGroup)
    {
        $this->fbGroup = $fbGroup;

        return $this;
    }

    /**
     * Get fbGroup
     *
     * @return string
     */
    public function getFbGroup()
    {
        return $this->fbGroup;
    }

    /**
     * Set twitterGroup
     *
     * @param string $twitterGroup
     *
     * @return Club
     */
    public function setTwitterGroup($twitterGroup)
    {
        $this->twitterGroup = $twitterGroup;

        return $this;
    }

    /**
     * Get twitterGroup
     *
     * @return string
     */
    public function getTwitterGroup()
    {
        return $this->twitterGroup;
    }

    /**
     * Set instagramGroup
     *
     * @param string $instagramGroup
     *
     * @return Club
     */
    public function setInstagramGroup($instagramGroup)
    {
        $this->instagramGroup = $instagramGroup;

        return $this;
    }

    /**
     * Get instagramGroup
     *
     * @return string
     */
    public function getInstagramGroup()
    {
        return $this->instagramGroup;
    }

    /**
     * Set youtubeGroup
     *
     * @param string $youtubeGroup
     *
     * @return Club
     */
    public function setYoutubeGroup($youtubeGroup)
    {
        $this->youtubeGroup = $youtubeGroup;

        return $this;
    }

    /**
     * Get youtubeGroup
     *
     * @return string
     */
    public function getYoutubeGroup()
    {
        return $this->youtubeGroup;
    }

    /**
     * Set ytUploadPlaylist
     *
     * @param string $ytUploadPlaylist
     *
     * @return Club
     */
    public function setYtUploadPlaylist($ytUploadPlaylist)
    {
        $this->ytUploadPlaylist = $ytUploadPlaylist;

        return $this;
    }

    /**
     * Get ytUploadPlaylist
     *
     * @return string
     */
    public function getYtUploadPlaylist()
    {
        return $this->ytUploadPlaylist;
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
}
