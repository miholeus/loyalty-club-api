<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * DeliveryType
 */
class DeliveryType
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    public function __toString()
    {
        return $this->getTitle();
    }

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
     * Set title.
     *
     * @param string $title
     *
     * @return DeliveryType
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
}
