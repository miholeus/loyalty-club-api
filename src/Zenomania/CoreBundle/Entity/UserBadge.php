<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * UserBadge
 */
class UserBadge
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $points;

    /**
     * @var \DateTime
     */
    private $createdOn;

    /**
     * @var \Zenomania\CoreBundle\Entity\Badge
     */
    private $badgeId;

    /**
     * @var \Zenomania\CoreBundle\Entity\User
     */
    private $user;


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
     * @return UserBadge
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
     * Set createdOn
     *
     * @param \DateTime $createdOn
     *
     * @return UserBadge
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    /**
     * Get createdOn
     *
     * @return \DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * Set badgeId
     *
     * @param \Zenomania\CoreBundle\Entity\Badge $badgeId
     *
     * @return UserBadge
     */
    public function setBadgeId(\Zenomania\CoreBundle\Entity\Badge $badgeId)
    {
        $this->badgeId = $badgeId;

        return $this;
    }

    /**
     * Get badgeId
     *
     * @return \Zenomania\CoreBundle\Entity\Badge
     */
    public function getBadgeId()
    {
        return $this->badgeId;
    }

    /**
     * Set user
     *
     * @param \Zenomania\CoreBundle\Entity\User $user
     *
     * @return UserBadge
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
}
