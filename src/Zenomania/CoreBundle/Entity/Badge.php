<?php

namespace Zenomania\CoreBundle\Entity;

use Zenomania\CoreBundle\Service\Upload\IdentifiableInterface;


/**
 * Badge
 */
class Badge implements IdentifiableInterface
{
    const TYPE_REGISTRATION = 'hello';
    const TYPE_VISITED_FIRST_MATCH = 'first match';
    const TYPE_PROFILE_COMPLETED = 'profile done';
    const TYPE_FORECAST_WINNER_MATCH_RESULT = 'forecast winner match result';
    const TYPE_MAKE_REPOST = 'make repost';

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $photo;


    /**
     * @var string
     */
    private $photoBadge;

    /**
     * @var BadgeType
     */
    private $typeId;

    /**
     * @var int
     */
    private $sort;

    /**
     * @var int
     */
    private $points;

    /**
     * @var int
     */
    private $maxPoints;

    /**
     * @var bool
     */
    private $active;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Badge
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

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Badge
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set photo
     *
     * @param string $photo
     *
     * @return Badge
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set typeId
     *
     * @param BadgeType $typeId
     *
     * @return Badge
     */
    public function setTypeId($typeId)
    {
        $this->typeId = $typeId;

        return $this;
    }

    /**
     * Get typeId
     *
     * @return BadgeType
     */
    public function getTypeId()
    {
        return $this->typeId;
    }

    /**
     * Set sort
     *
     * @param integer $sort
     *
     * @return Badge
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * Get sort
     *
     * @return int
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Set points
     *
     * @param integer $points
     *
     * @return Badge
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get points
     *
     * @return int
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Set maxPoints
     *
     * @param integer $maxPoints
     *
     * @return Badge
     */
    public function setMaxPoints($maxPoints)
    {
        $this->maxPoints = $maxPoints;

        return $this;
    }

    /**
     * Get maxPoints
     *
     * @return int
     */
    public function getMaxPoints()
    {
        return $this->maxPoints;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Badge
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @return string
     */
    public function getPhotoBadge()
    {
        return $this->photoBadge;
    }

    /**
     * @param string $photoBadge
     */
    public function setPhotoBadge($photoBadge)
    {
        $this->photoBadge = $photoBadge;
    }
}
