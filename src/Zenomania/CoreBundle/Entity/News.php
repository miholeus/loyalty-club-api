<?php

namespace Zenomania\CoreBundle\Entity;

use Zenomania\CoreBundle\Form\Model\PostVkontakte;

/**
 * News
 */
class News
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string|null
     */
    private $text;

    /**
     * @var int|null
     */
    private $vkId;

    /**
     * @var \DateTime
     */
    private $dt;

    /**
     * @var string|null
     */
    private $photo;

    /**
     * @var string|null
     */
    private $video;

    /**
     * @var array|null
     */
    private $tags;

    /**
     * @var bool
     */
    private $published = true;

    /**
     * @var \DateTime
     */
    private $createdOn;

    /**
     * @var \DateTime|null
     */
    private $updatedOn;

    /**
     * @var string
     */
    private $status = 'new';


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set text.
     *
     * @param string|null $text
     *
     * @return News
     */
    public function setText($text = null)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text.
     *
     * @return string|null
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set vkId.
     *
     * @param int|null $vkId
     *
     * @return News
     */
    public function setVkId($vkId = null)
    {
        $this->vkId = $vkId;

        return $this;
    }

    /**
     * Get vkId.
     *
     * @return int|null
     */
    public function getVkId()
    {
        return $this->vkId;
    }

    /**
     * Set dt.
     *
     * @param \DateTime $dt
     *
     * @return News
     */
    public function setDt($dt)
    {
        $this->dt = $dt;

        return $this;
    }

    /**
     * Get dt.
     *
     * @return \DateTime
     */
    public function getDt()
    {
        return $this->dt;
    }

    /**
     * Set photo.
     *
     * @param string|null $photo
     *
     * @return News
     */
    public function setPhoto($photo = null)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo.
     *
     * @return string|null
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set video.
     *
     * @param string|null $video
     *
     * @return News
     */
    public function setVideo($video = null)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Get video.
     *
     * @return string|null
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * Set tags.
     *
     * @param array|null $tags
     *
     * @return News
     */
    public function setTags($tags = null)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Get tags.
     *
     * @return array|null
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set published.
     *
     * @param bool $published
     *
     * @return News
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published.
     *
     * @return bool
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set createdOn.
     *
     * @param \DateTime $createdOn
     *
     * @return News
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    /**
     * Get createdOn.
     *
     * @return \DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * Set updatedOn.
     *
     * @param \DateTime|null $updatedOn
     *
     * @return News
     */
    public function setUpdatedOn($updatedOn = null)
    {
        $this->updatedOn = $updatedOn;

        return $this;
    }

    /**
     * Get updatedOn.
     *
     * @return \DateTime|null
     */
    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }

    /**
     * Set status.
     *
     * @param string $status
     *
     * @return News
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    public static function fromPost(PostVkontakte $post){
        $self = new self();
        $self->setText($post->getText());
        $self->setVkId($post->getId());
        $self->setDt($post->getDate());
        $self->setPhoto($post->getPhoto());
        $self->setVideo($post->getVideo());
        $self->setTags($post->getTags());
        $self->setCreatedOn(new \DateTime());

        return $self;
    }
}
