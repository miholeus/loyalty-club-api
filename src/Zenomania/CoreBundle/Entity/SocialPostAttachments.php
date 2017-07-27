<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * SocialPostAttachments
 */
class SocialPostAttachments
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $type = 'video';

    /**
     * @var string
     */
    private $outerId;

    /**
     * @var string
     */
    private $innerLink;

    /**
     * @var string
     */
    private $outerLink;

    /**
     * @var string
     */
    private $picSmall;

    /**
     * @var string
     */
    private $picBig;

    /**
     * @var \Zenomania\CoreBundle\Entity\SocialPost
     */
    private $post;


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
     * Set type
     *
     * @param string $type
     *
     * @return SocialPostAttachments
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set outerId
     *
     * @param string $outerId
     *
     * @return SocialPostAttachments
     */
    public function setOuterId($outerId)
    {
        $this->outerId = $outerId;

        return $this;
    }

    /**
     * Get outerId
     *
     * @return string
     */
    public function getOuterId()
    {
        return $this->outerId;
    }

    /**
     * Set innerLink
     *
     * @param string $innerLink
     *
     * @return SocialPostAttachments
     */
    public function setInnerLink($innerLink)
    {
        $this->innerLink = $innerLink;

        return $this;
    }

    /**
     * Get innerLink
     *
     * @return string
     */
    public function getInnerLink()
    {
        return $this->innerLink;
    }

    /**
     * Set outerLink
     *
     * @param string $outerLink
     *
     * @return SocialPostAttachments
     */
    public function setOuterLink($outerLink)
    {
        $this->outerLink = $outerLink;

        return $this;
    }

    /**
     * Get outerLink
     *
     * @return string
     */
    public function getOuterLink()
    {
        return $this->outerLink;
    }

    /**
     * Set picSmall
     *
     * @param string $picSmall
     *
     * @return SocialPostAttachments
     */
    public function setPicSmall($picSmall)
    {
        $this->picSmall = $picSmall;

        return $this;
    }

    /**
     * Get picSmall
     *
     * @return string
     */
    public function getPicSmall()
    {
        return $this->picSmall;
    }

    /**
     * Set picBig
     *
     * @param string $picBig
     *
     * @return SocialPostAttachments
     */
    public function setPicBig($picBig)
    {
        $this->picBig = $picBig;

        return $this;
    }

    /**
     * Get picBig
     *
     * @return string
     */
    public function getPicBig()
    {
        return $this->picBig;
    }

    /**
     * Set post
     *
     * @param \Zenomania\CoreBundle\Entity\SocialPost $post
     *
     * @return SocialPostAttachments
     */
    public function setPost(\Zenomania\CoreBundle\Entity\SocialPost $post = null)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return \Zenomania\CoreBundle\Entity\SocialPost
     */
    public function getPost()
    {
        return $this->post;
    }
}
