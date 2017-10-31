<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 06.10.2017
 * Time: 15:45
 */

namespace Zenomania\CoreBundle\Entity;


/**
 * Class PointsType
 */
class PointsType
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $type;

    /**
     * @var integer
     */
    private $interval;

    /**
     * @var integer
     */
    private $value;

    /**
     * @var boolean
     */
    private $isPercent;

    /**
     * @var boolean
     */
    private $isActive;

    /**
     * @var \DateTime
     */
    private $createdOn;

    public function __construct()
    {
        $this->setCreatedOn(new \DateTime());
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return PointsType
     */
    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return int
     */
    public function getInterval()
    {
        return $this->interval;
    }

    /**
     * @param int $interval
     * @return PointsType
     */
    public function setInterval(int $interval)
    {
        $this->interval = $interval;

        return $this;
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param int $value
     * @return PointsType
     */
    public function setValue(int $value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsPercent()
    {
        return $this->isPercent;
    }

    /**
     * @param bool $isPercent
     * @return $this
     */
    public function setIsPercent(bool $isPercent)
    {
        $this->isPercent = $isPercent;

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     * @return $this
     */
    public function setIsActive(bool $isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @param \DateTime $createdOn
     * @return $this
     */
    public function setCreatedOn(\DateTime $createdOn)
    {
        $this->createdOn = $createdOn;

        return $this;
    }
}
