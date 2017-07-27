<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * ProgressItems
 */
class ProgressItems
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $progressClass;

    /**
     * @var string
     */
    private $progressKey;

    /**
     * @var string
     */
    private $title;


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
     * Set progressClass
     *
     * @param string $progressClass
     *
     * @return ProgressItems
     */
    public function setProgressClass($progressClass)
    {
        $this->progressClass = $progressClass;

        return $this;
    }

    /**
     * Get progressClass
     *
     * @return string
     */
    public function getProgressClass()
    {
        return $this->progressClass;
    }

    /**
     * Set progressKey
     *
     * @param string $progressKey
     *
     * @return ProgressItems
     */
    public function setProgressKey($progressKey)
    {
        $this->progressKey = $progressKey;

        return $this;
    }

    /**
     * Get progressKey
     *
     * @return string
     */
    public function getProgressKey()
    {
        return $this->progressKey;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return ProgressItems
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
}

