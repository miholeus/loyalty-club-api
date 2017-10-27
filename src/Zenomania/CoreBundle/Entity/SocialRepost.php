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
    private $vkId;

    /**
     * @var \DateTime
     */
    private $dt;

    /**
     * @var \DateTime
     */
    private $createdOn;

    /**
     * @var \Zenomania\CoreBundle\Entity\User
     */
    private $user;

    /**
     * @var \Zenomania\CoreBundle\Entity\News
     */
    private $news;

    /**
    * @param array $data
    * @return SocialRepost
    */
    public static function fromArray(array $data) : SocialRepost
    {
        $self = new self();
        foreach ($data as $key => $value) {
            $self->{"set".ucfirst($key)}($value);
        }
        return $self;
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
     * Set vkId
     *
     * @param string $vkId
     *
     * @return SocialRepost
     */
    public function setVkIid($vkId)
    {
        $this->vkId = $vkId;

        return $this;
    }

    /**
     * Get vkId
     *
     * @return string
     */
    public function getVkId()
    {
        return $this->vkId;
    }

    /**
     * Set dt
     *
     * @param \DateTime $dt
     *
     * @return SocialRepost
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
     * Set user
     *
     * @param \Zenomania\CoreBundle\Entity\User $user
     *
     * @return SocialRepost
     */
    public function setUser(\Zenomania\CoreBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Zenomania\CoreBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set news
     *
     * @param \Zenomania\CoreBundle\Entity\News $news
     *
     * @return SocialRepost
     */
    public function setNews(\Zenomania\CoreBundle\Entity\News $news = null)
    {
        $this->news = $news;

        return $this;
    }

    /**
     * Get news
     *
     * @return \Zenomania\CoreBundle\Entity\News
     */
    public function getNews()
    {
        return $this->news;
    }
}
