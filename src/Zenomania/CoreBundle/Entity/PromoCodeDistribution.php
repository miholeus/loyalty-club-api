<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * PromoCodeDistribution
 */
class PromoCodeDistribution
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $numberStart;

    /**
     * @var string
     */
    private $numberEnd;

    /**
     * @var \Zenomania\CoreBundle\Entity\Event
     */
    private $event;

    /**
     * @var \Zenomania\CoreBundle\Entity\PromoAction
     */
    private $promoAction;

    /**
     * @var \Zenomania\CoreBundle\Entity\PromoCodeDistributionArea
     */
    private $area;


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
     * Set numberStart
     *
     * @param string $numberStart
     *
     * @return PromoCodeDistribution
     */
    public function setNumberStart($numberStart)
    {
        $this->numberStart = $numberStart;

        return $this;
    }

    /**
     * Get numberStart
     *
     * @return string
     */
    public function getNumberStart()
    {
        return $this->numberStart;
    }

    /**
     * Set numberEnd
     *
     * @param string $numberEnd
     *
     * @return PromoCodeDistribution
     */
    public function setNumberEnd($numberEnd)
    {
        $this->numberEnd = $numberEnd;

        return $this;
    }

    /**
     * Get numberEnd
     *
     * @return string
     */
    public function getNumberEnd()
    {
        return $this->numberEnd;
    }

    /**
     * Set event
     *
     * @param \Zenomania\CoreBundle\Entity\Event $event
     *
     * @return PromoCodeDistribution
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
     * Set promoAction
     *
     * @param \Zenomania\CoreBundle\Entity\PromoAction $promoAction
     *
     * @return PromoCodeDistribution
     */
    public function setPromoAction(\Zenomania\CoreBundle\Entity\PromoAction $promoAction = null)
    {
        $this->promoAction = $promoAction;

        return $this;
    }

    /**
     * Get promoAction
     *
     * @return \Zenomania\CoreBundle\Entity\PromoAction
     */
    public function getPromoAction()
    {
        return $this->promoAction;
    }

    /**
     * Set area
     *
     * @param \Zenomania\CoreBundle\Entity\PromoCodeDistributionArea $area
     *
     * @return PromoCodeDistribution
     */
    public function setArea(\Zenomania\CoreBundle\Entity\PromoCodeDistributionArea $area = null)
    {
        $this->area = $area;

        return $this;
    }

    /**
     * Get area
     *
     * @return \Zenomania\CoreBundle\Entity\PromoCodeDistributionArea
     */
    public function getArea()
    {
        return $this->area;
    }
}

