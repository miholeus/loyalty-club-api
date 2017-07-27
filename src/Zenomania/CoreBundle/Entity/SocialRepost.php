<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * SocialRepost
 */
class SocialRepost
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $network;

    /**
     * @var string
     */
    private $userOuterid;

    /**
     * @var string
     */
    private $repostOuterid;

    /**
     * @var \DateTime
     */
    private $repostDt;

    /**
     * @var \Zenomania\CoreBundle\Entity\Person
     */
    private $person;

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
     * Set network
     *
     * @param string $network
     *
     * @return SocialRepost
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
     * Set userOuterid
     *
     * @param string $userOuterid
     *
     * @return SocialRepost
     */
    public function setUserOuterid($userOuterid)
    {
        $this->userOuterid = $userOuterid;

        return $this;
    }

    /**
     * Get userOuterid
     *
     * @return string
     */
    public function getUserOuterid()
    {
        return $this->userOuterid;
    }

    /**
     * Set repostOuterid
     *
     * @param string $repostOuterid
     *
     * @return SocialRepost
     */
    public function setRepostOuterid($repostOuterid)
    {
        $this->repostOuterid = $repostOuterid;

        return $this;
    }

    /**
     * Get repostOuterid
     *
     * @return string
     */
    public function getRepostOuterid()
    {
        return $this->repostOuterid;
    }

    /**
     * Set repostDt
     *
     * @param \DateTime $repostDt
     *
     * @return SocialRepost
     */
    public function setRepostDt($repostDt)
    {
        $this->repostDt = $repostDt;

        return $this;
    }

    /**
     * Get repostDt
     *
     * @return \DateTime
     */
    public function getRepostDt()
    {
        return $this->repostDt;
    }

    /**
     * Set person
     *
     * @param \Zenomania\CoreBundle\Entity\Person $person
     *
     * @return SocialRepost
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

    /**
     * Set post
     *
     * @param \Zenomania\CoreBundle\Entity\SocialPost $post
     *
     * @return SocialRepost
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
