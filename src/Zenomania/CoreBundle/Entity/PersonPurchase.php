<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * PersonPurchase
 */
class PersonPurchase
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $appId;

    /**
     * @var string
     */
    private $pricePoints;

    /**
     * @var string
     */
    private $urlCalled;

    /**
     * @var string
     */
    private $queryString;

    /**
     * @var string
     */
    private $checksum;

    /**
     * @var \DateTime
     */
    private $datetime;

    /**
     * @var boolean
     */
    private $status;

    /**
     * @var \DateTime
     */
    private $updated;

    /**
     * @var string
     */
    private $shipTo;

    /**
     * @var \Zenomania\CoreBundle\Entity\Item
     */
    private $item;

    /**
     * @var \Zenomania\CoreBundle\Entity\ItemHow2get
     */
    private $how2get;

    /**
     * @var \Zenomania\CoreBundle\Entity\Person
     */
    private $person;


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
     * Set appId
     *
     * @param integer $appId
     *
     * @return PersonPurchase
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
     * @return PersonPurchase
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
     * Set urlCalled
     *
     * @param string $urlCalled
     *
     * @return PersonPurchase
     */
    public function setUrlCalled($urlCalled)
    {
        $this->urlCalled = $urlCalled;

        return $this;
    }

    /**
     * Get urlCalled
     *
     * @return string
     */
    public function getUrlCalled()
    {
        return $this->urlCalled;
    }

    /**
     * Set queryString
     *
     * @param string $queryString
     *
     * @return PersonPurchase
     */
    public function setQueryString($queryString)
    {
        $this->queryString = $queryString;

        return $this;
    }

    /**
     * Get queryString
     *
     * @return string
     */
    public function getQueryString()
    {
        return $this->queryString;
    }

    /**
     * Set checksum
     *
     * @param string $checksum
     *
     * @return PersonPurchase
     */
    public function setChecksum($checksum)
    {
        $this->checksum = $checksum;

        return $this;
    }

    /**
     * Get checksum
     *
     * @return string
     */
    public function getChecksum()
    {
        return $this->checksum;
    }

    /**
     * Set datetime
     *
     * @param \DateTime $datetime
     *
     * @return PersonPurchase
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * Get datetime
     *
     * @return \DateTime
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return PersonPurchase
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return PersonPurchase
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set shipTo
     *
     * @param string $shipTo
     *
     * @return PersonPurchase
     */
    public function setShipTo($shipTo)
    {
        $this->shipTo = $shipTo;

        return $this;
    }

    /**
     * Get shipTo
     *
     * @return string
     */
    public function getShipTo()
    {
        return $this->shipTo;
    }

    /**
     * Set item
     *
     * @param \Zenomania\CoreBundle\Entity\Item $item
     *
     * @return PersonPurchase
     */
    public function setItem(\Zenomania\CoreBundle\Entity\Item $item = null)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Get item
     *
     * @return \Zenomania\CoreBundle\Entity\Item
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Set how2get
     *
     * @param \Zenomania\CoreBundle\Entity\ItemHow2get $how2get
     *
     * @return PersonPurchase
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

    /**
     * Set person
     *
     * @param \Zenomania\CoreBundle\Entity\Person $person
     *
     * @return PersonPurchase
     */
    public function setPerson(\Zenomania\CoreBundle\Entity\Person $person = null)
    {
        $this->person = $person;

        return $this;
    }

    /**
     * Get person
     *
     * @return \Zenomania\CoreBundle\Entity\Person
     */
    public function getPerson()
    {
        return $this->person;
    }
}

