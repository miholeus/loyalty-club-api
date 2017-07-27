<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * SocialPost
 */
class SocialPost
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $clubId = '0';

    /**
     * @var string
     */
    private $network;

    /**
     * @var string
     */
    private $groupId = '';

    /**
     * @var string
     */
    private $outerid = '';

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $text;

    /**
     * @var string
     */
    private $textbig;

    /**
     * @var string
     */
    private $link;

    /**
     * @var string
     */
    private $pic;

    /**
     * @var string
     */
    private $picbig;

    /**
     * @var integer
     */
    private $reposts = '0';

    /**
     * @var integer
     */
    private $likes = '0';

    /**
     * @var integer
     */
    private $comments = '0';

    /**
     * @var integer
     */
    private $views = '0';

    /**
     * @var boolean
     */
    private $moder = '0';


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
     * Set clubId
     *
     * @param integer $clubId
     *
     * @return SocialPost
     */
    public function setClubId($clubId)
    {
        $this->clubId = $clubId;

        return $this;
    }

    /**
     * Get clubId
     *
     * @return integer
     */
    public function getClubId()
    {
        return $this->clubId;
    }

    /**
     * Set network
     *
     * @param string $network
     *
     * @return SocialPost
     */
    public function setNetwork($network)
    {
        $this->network = $network;

        return $this;
    }

    /**
     * Get network
     *
     * @return string
     */
    public function getNetwork()
    {
        return $this->network;
    }

    /**
     * Set groupId
     *
     * @param string $groupId
     *
     * @return SocialPost
     */
    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;

        return $this;
    }

    /**
     * Get groupId
     *
     * @return string
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * Set outerid
     *
     * @param string $outerid
     *
     * @return SocialPost
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return SocialPost
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
     * Set text
     *
     * @param string $text
     *
     * @return SocialPost
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set textbig
     *
     * @param string $textbig
     *
     * @return SocialPost
     */
    public function setTextbig($textbig)
    {
        $this->textbig = $textbig;

        return $this;
    }

    /**
     * Get textbig
     *
     * @return string
     */
    public function getTextbig()
    {
        return $this->textbig;
    }

    /**
     * Set link
     *
     * @param string $link
     *
     * @return SocialPost
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set pic
     *
     * @param string $pic
     *
     * @return SocialPost
     */
    public function setPic($pic)
    {
        $this->pic = $pic;

        return $this;
    }

    /**
     * Get pic
     *
     * @return string
     */
    public function getPic()
    {
        return $this->pic;
    }

    /**
     * Set picbig
     *
     * @param string $picbig
     *
     * @return SocialPost
     */
    public function setPicbig($picbig)
    {
        $this->picbig = $picbig;

        return $this;
    }

    /**
     * Get picbig
     *
     * @return string
     */
    public function getPicbig()
    {
        return $this->picbig;
    }

    /**
     * Set reposts
     *
     * @param integer $reposts
     *
     * @return SocialPost
     */
    public function setReposts($reposts)
    {
        $this->reposts = $reposts;

        return $this;
    }

    /**
     * Get reposts
     *
     * @return integer
     */
    public function getReposts()
    {
        return $this->reposts;
    }

    /**
     * Set likes
     *
     * @param integer $likes
     *
     * @return SocialPost
     */
    public function setLikes($likes)
    {
        $this->likes = $likes;

        return $this;
    }

    /**
     * Get likes
     *
     * @return integer
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * Set comments
     *
     * @param integer $comments
     *
     * @return SocialPost
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get comments
     *
     * @return integer
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set views
     *
     * @param integer $views
     *
     * @return SocialPost
     */
    public function setViews($views)
    {
        $this->views = $views;

        return $this;
    }

    /**
     * Get views
     *
     * @return integer
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * Set moder
     *
     * @param boolean $moder
     *
     * @return SocialPost
     */
    public function setModer($moder)
    {
        $this->moder = $moder;

        return $this;
    }

    /**
     * Get moder
     *
     * @return boolean
     */
    public function getModer()
    {
        return $this->moder;
    }
}

