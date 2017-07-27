<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * Item
 */
class Item
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var boolean
     */
    private $active = '0';

    /**
     * @var integer
     */
    private $parentItem;

    /**
     * @var integer
     */
    private $rule;

    /**
     * @var integer
     */
    private $outerId;

    /**
     * @var integer
     */
    private $appId;

    /**
     * @var string
     */
    private $pricePoints = '0';

    /**
     * @var string
     */
    private $priceRub = '0';

    /**
     * @var string
     */
    private $name = 'Приз';

    /**
     * @var string
     */
    private $img = '/static/img/prize1.png';

    /**
     * @var boolean
     */
    private $sortorder = '0';

    /**
     * @var \Zenomania\CoreBundle\Entity\Event
     */
    private $event;

    /**
     * @var \Zenomania\CoreBundle\Entity\ItemHow2get
     */
    private $how2get;


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
     * Set active
     *
     * @param boolean $active
     *
     * @return Item
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set parentItem
     *
     * @param integer $parentItem
     *
     * @return Item
     */
    public function setParentItem($parentItem)
    {
        $this->parentItem = $parentItem;

        return $this;
    }

    /**
     * Get parentItem
     *
     * @return integer
     */
    public function getParentItem()
    {
        return $this->parentItem;
    }

    /**
     * Set rule
     *
     * @param integer $rule
     *
     * @return Item
     */
    public function setRule($rule)
    {
        $this->rule = $rule;

        return $this;
    }

    /**
     * Get rule
     *
     * @return integer
     */
    public function getRule()
    {
        return $this->rule;
    }

    /**
     * Set outerId
     *
     * @param integer $outerId
     *
     * @return Item
     */
    public function setOuterId($outerId)
    {
        $this->outerId = $outerId;

        return $this;
    }

    /**
     * Get outerId
     *
     * @return integer
     */
    public function getOuterId()
    {
        return $this->outerId;
    }

    /**
     * Set appId
     *
     * @param integer $appId
     *
     * @return Item
     */
    public function setAppId($appId)
    {
        $this->appId = $appId;

        return $this;
    }

    /**
     * Get appId
     *
     * @return integer
     */
    public function getAppId()
    {
        return $this->appId;
    }

    /**
     * Set pricePoints
     *
     * @param string $pricePoints
     *
     * @return Item
     */
    public function setPricePoints($pricePoints)
    {
        $this->pricePoints = $pricePoints;

        return $this;
    }

    /**
     * Get pricePoints
     *
     * @return string
     */
    public function getPricePoints()
    {
        return $this->pricePoints;
    }

    /**
     * Set priceRub
     *
     * @param string $priceRub
     *
     * @return Item
     */
    public function setPriceRub($priceRub)
    {
        $this->priceRub = $priceRub;

        return $this;
    }

    /**
     * Get priceRub
     *
     * @return string
     */
    public function getPriceRub()
    {
        return $this->priceRub;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Item
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
     * Set img
     *
     * @param string $img
     *
     * @return Item
     */
    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }

    /**
     * Get img
     *
     * @return string
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * Set sortorder
     *
     * @param boolean $sortorder
     *
     * @return Item
     */
    public function setSortorder($sortorder)
    {
        $this->sortorder = $sortorder;

        return $this;
    }

    /**
     * Get sortorder
     *
     * @return boolean
     */
    public function getSortorder()
    {
        return $this->sortorder;
    }

    /**
     * Set event
     *
     * @param \Zenomania\CoreBundle\Entity\Event $event
     *
     * @return Item
     */
    public function setEvent(\Zenomania\CoreBundle\Entity\Event $event = null)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return \Zenomania\CoreBundle\Entity\Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set how2get
     *
     * @param \Zenomania\CoreBundle\Entity\ItemHow2get $how2get
     *
     * @return Item
     */
    public function setHow2get(\Zenomania\CoreBundle\Entity\ItemHow2get $how2get = null)
    {
        $this->how2get = $how2get;

        return $this;
    }

    /**
     * Get how2get
     *
     * @return \Zenomania\CoreBundle\Entity\ItemHow2get
     */
    public function getHow2get()
    {
        return $this->how2get;
    }
}

