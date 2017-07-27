<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * PointsStatus
 */
class PointsStatus
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $points = '0';

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
     * Set points
     *
     * @param integer $points
     *
     * @return PointsStatus
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get points
     *
     * @return integer
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return PointsStatus
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
