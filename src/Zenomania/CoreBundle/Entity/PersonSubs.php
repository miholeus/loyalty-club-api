<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * PersonSubs
 */
class PersonSubs
{
    /**
     * @var integer
     */
    private $personId;

    /**
     * @var integer
     */
    private $listId;

    /**
     * @var boolean
     */
    private $enabled;


    /**
     * Set personId
     *
     * @param integer $personId
     *
     * @return PersonSubs
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
     * Set listId
     *
     * @param integer $listId
     *
     * @return PersonSubs
     */
    public function setListId($listId)
    {
        $this->listId = $listId;

        return $this;
    }

    /**
     * Get listId
     *
     * @return integer
     */
    public function getListId()
    {
        return $this->listId;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return PersonSubs
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }
}

