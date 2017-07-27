<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * EmailDispatch
 */
class EmailDispatch
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $subject = '';

    /**
     * @var string
     */
    private $body;

    /**
     * @var string
     */
    private $source = 'html';

    /**
     * @var string
     */
    private $category = 'info';

    /**
     * @var string
     */
    private $name = 'Рас-рас-рассылка';

    /**
     * @var string
     */
    private $active = 'N';

    /**
     * @var \DateTime
     */
    private $createdDate;

    /**
     * @var integer
     */
    private $createdActor;


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
     * Set subject
     *
     * @param string $subject
     *
     * @return EmailDispatch
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set body
     *
     * @param string $body
     *
     * @return EmailDispatch
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set source
     *
     * @param string $source
     *
     * @return EmailDispatch
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set category
     *
     * @param string $category
     *
     * @return EmailDispatch
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return EmailDispatch
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
     * Set active
     *
     * @param string $active
     *
     * @return EmailDispatch
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return string
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     *
     * @return EmailDispatch
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * Get createdDate
     *
     * @return \DateTime
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Set createdActor
     *
     * @param integer $createdActor
     *
     * @return EmailDispatch
     */
    public function setCreatedActor($createdActor)
    {
        $this->createdActor = $createdActor;

        return $this;
    }

    /**
     * Get createdActor
     *
     * @return integer
     */
    public function getCreatedActor()
    {
        return $this->createdActor;
    }
}
