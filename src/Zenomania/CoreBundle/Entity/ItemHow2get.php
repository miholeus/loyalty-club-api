<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * ItemHow2get
 */
class ItemHow2get
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name = '';

    /**
     * @var string
     */
    private $displayText;

    /**
     * @var string
     */
    private $purchaseText;


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
     * Set name
     *
     * @param string $name
     *
     * @return ItemHow2get
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
     * Set displayText
     *
     * @param string $displayText
     *
     * @return ItemHow2get
     */
    public function setDisplayText($displayText)
    {
        $this->displayText = $displayText;

        return $this;
    }

    /**
     * Get displayText
     *
     * @return string
     */
    public function getDisplayText()
    {
        return $this->displayText;
    }

    /**
     * Set purchaseText
     *
     * @param string $purchaseText
     *
     * @return ItemHow2get
     */
    public function setPurchaseText($purchaseText)
    {
        $this->purchaseText = $purchaseText;

        return $this;
    }

    /**
     * Get purchaseText
     *
     * @return string
     */
    public function getPurchaseText()
    {
        return $this->purchaseText;
    }
}

