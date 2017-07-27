<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * Security
 */
class Security
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $personId = '0';

    /**
     * @var integer
     */
    private $type = '0';

    /**
     * @var integer
     */
    private $offenceCount = '0';

    /**
     * @var string
     */
    private $comment = '0';


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
     * Set personId
     *
     * @param integer $personId
     *
     * @return Security
     */
    public function setPersonId($personId)
    {
        $this->personId = $personId;

        return $this;
    }

    /**
     * Get personId
     *
     * @return integer
     */
    public function getPersonId()
    {
        return $this->personId;
    }

    /**
     * Set type
     *
     * @param integer $type
     *
     * @return Security
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set offenceCount
     *
     * @param integer $offenceCount
     *
     * @return Security
     */
    public function setOffenceCount($offenceCount)
    {
        $this->offenceCount = $offenceCount;

        return $this;
    }

    /**
     * Get offenceCount
     *
     * @return integer
     */
    public function getOffenceCount()
    {
        return $this->offenceCount;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Security
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }
}
