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
     * @var \Zenomania\CoreBundle\Entity\PromoCodeDistributionArea
     */
    private $area;

    /**
     * @var \Zenomania\CoreBundle\Entity\Season
     */
    private $season;
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

    /**
     * Set season
     *
     * @param \Zenomania\CoreBundle\Entity\Season $season
     *
     * @return PromoCodeDistribution
     */
    public function setSeason(\Zenomania\CoreBundle\Entity\Season $season = null)
    {
        $this->season = $season;

        return $this;
    }

    /**
     * Get season
     *
     * @return \Zenomania\CoreBundle\Entity\Season
     */
    public function getSeason()
    {
        return $this->season;
    }
}
