<?php

namespace Zenomania\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Event
 */
class Event
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var boolean
     */
    private $purchasable;

    /**
     * @var string
     */
    private $chship = 'NA';

    /**
     * @var boolean
     */
    private $scoreHome = '0';

    /**
     * @var boolean
     */
    private $scoreGuest = '0';

    /**
     * @var boolean
     */
    private $scoreSaved = '0';

    /**
     * @var \Zenomania\CoreBundle\Entity\Club
     */
    private $clubHome;

    /**
     * @var \Zenomania\CoreBundle\Entity\Club
     */
    private $clubGuest;

    /**
     * @var \Zenomania\CoreBundle\Entity\Place
     */
    private $place;

    /**
     * @var \Zenomania\CoreBundle\Entity\Sport
     */
    private $sport;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $personPoint;

    /**
     * @var boolean
     */
    private $isLineUp;

    /**
     * @var string
     */
    private $scoreInRounds;

    /**
     * @var ArrayCollection
     */
    private $rounds;

    /**
     * @var \Zenomania\CoreBundle\Entity\Player
     */
    private $mvp;

    /**
     * @var \Zenomania\CoreBundle\Entity\Season
     */
    private $season;

    /**
     * @var ArrayCollection
     */
    private $lineup;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->personPoint = new ArrayCollection();
        $this->rounds = new ArrayCollection();
        $this->lineup = new ArrayCollection();
    }

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
     * @return Event
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Event
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set purchasable
     *
     * @param boolean $purchasable
     *
     * @return Event
     */
    public function setPurchasable($purchasable)
    {
        $this->purchasable = $purchasable;

        return $this;
    }

    /**
     * Get purchasable
     *
     * @return boolean
     */
    public function getPurchasable()
    {
        return $this->purchasable;
    }

    /**
     * Set chship
     *
     * @param string $chship
     *
     * @return Event
     */
    public function setChship($chship)
    {
        $this->chship = $chship;

        return $this;
    }

    /**
     * Get chship
     *
     * @return string
     */
    public function getChship()
    {
        return $this->chship;
    }

    /**
     * Set scoreHome
     *
     * @param boolean $scoreHome
     *
     * @return Event
     */
    public function setScoreHome($scoreHome)
    {
        $this->scoreHome = $scoreHome;

        return $this;
    }

    /**
     * Get scoreHome
     *
     * @return boolean
     */
    public function getScoreHome()
    {
        return $this->scoreHome;
    }

    /**
     * Set scoreGuest
     *
     * @param boolean $scoreGuest
     *
     * @return Event
     */
    public function setScoreGuest($scoreGuest)
    {
        $this->scoreGuest = $scoreGuest;

        return $this;
    }

    /**
     * Get scoreGuest
     *
     * @return boolean
     */
    public function getScoreGuest()
    {
        return $this->scoreGuest;
    }

    /**
     * Set scoreSaved
     *
     * @param boolean $scoreSaved
     *
     * @return Event
     */
    public function setScoreSaved($scoreSaved)
    {
        $this->scoreSaved = $scoreSaved;

        return $this;
    }

    /**
     * Get scoreSaved
     *
     * @return boolean
     */
    public function getScoreSaved()
    {
        return $this->scoreSaved;
    }

    /**
     * Set clubHome
     *
     * @param \Zenomania\CoreBundle\Entity\Club $clubHome
     *
     * @return Event
     */
    public function setClubHome(\Zenomania\CoreBundle\Entity\Club $clubHome = null)
    {
        $this->clubHome = $clubHome;

        return $this;
    }

    /**
     * Get clubHome
     *
     * @return \Zenomania\CoreBundle\Entity\Club
     */
    public function getClubHome()
    {
        return $this->clubHome;
    }

    /**
     * Set clubGuest
     *
     * @param \Zenomania\CoreBundle\Entity\Club $clubGuest
     *
     * @return Event
     */
    public function setClubGuest(\Zenomania\CoreBundle\Entity\Club $clubGuest = null)
    {
        $this->clubGuest = $clubGuest;

        return $this;
    }

    /**
     * Get clubGuest
     *
     * @return \Zenomania\CoreBundle\Entity\Club
     */
    public function getClubGuest()
    {
        return $this->clubGuest;
    }

    /**
     * Set place
     *
     * @param \Zenomania\CoreBundle\Entity\Place $place
     *
     * @return Event
     */
    public function setPlace(\Zenomania\CoreBundle\Entity\Place $place = null)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place
     *
     * @return \Zenomania\CoreBundle\Entity\Place
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Set sport
     *
     * @param \Zenomania\CoreBundle\Entity\Sport $sport
     *
     * @return Event
     */
    public function setSport(\Zenomania\CoreBundle\Entity\Sport $sport = null)
    {
        $this->sport = $sport;

        return $this;
    }

    /**
     * Get sport
     *
     * @return \Zenomania\CoreBundle\Entity\Sport
     */
    public function getSport()
    {
        return $this->sport;
    }

    /**
     * Add personPoint
     *
     * @param \Zenomania\CoreBundle\Entity\PersonPoints $personPoint
     *
     * @return Event
     */
    public function addPersonPoint(\Zenomania\CoreBundle\Entity\PersonPoints $personPoint)
    {
        $this->personPoint[] = $personPoint;

        return $this;
    }

    /**
     * Remove personPoint
     *
     * @param \Zenomania\CoreBundle\Entity\PersonPoints $personPoint
     */
    public function removePersonPoint(\Zenomania\CoreBundle\Entity\PersonPoints $personPoint)
    {
        $this->personPoint->removeElement($personPoint);
    }

    /**
     * Get personPoint
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPersonPoint()
    {
        return $this->personPoint;
    }

    /**
     * @return \Zenomania\CoreBundle\Entity\Player
     */
    public function getMvp()
    {
        return $this->mvp;
    }

    /**
     * @param \Zenomania\CoreBundle\Entity\Player $mvp
     *
     * @return Event
     */
    public function setMvp(\Zenomania\CoreBundle\Entity\Player $mvp)
    {
        $this->mvp = $mvp;

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsLineUp()
    {
        return $this->isLineUp;
    }

    /**
     * @param bool $isLineUp
     *
     * @return \Zenomania\CoreBundle\Entity\Event
     */
    public function setIsLineUp(bool $isLineUp)
    {
        $this->isLineUp = $isLineUp;

        return $this;
    }

    /**
     * @return string
     */
    public function getScoreInRounds()
    {
        return $this->scoreInRounds;
    }

    /**
     * @param string $scoreInRounds
     *
     * @return Event
     */
    public function setScoreInRounds($scoreInRounds)
    {
        $this->scoreInRounds = $scoreInRounds;

        return $this;
    }

    /**
     * Преобразует массив со счётом каждого раунда в строку, типа 25:21, 25:23, 25:20
     *
     * @param ArrayCollection $rounds
     *
     * @return Event
     */
    public function reverseRounds($rounds)
    {
        $array = [];
        foreach ($rounds as $round) {
            /** @var ScoreInRound $round */
            if (($round->getHomeScore() <= 15) && ($round->getGuestScore() <= 15)) {
                break;
            }

            $array[] = $round->getHomeScore() . ":" . $round->getGuestScore();
        }

        $this->scoreInRounds = implode(', ', $array);

        return $this;
    }

    /**
     * Преобразует строку в массив со счётом каждого раунда
     *
     * @param string $scoreInRounds
     */
    public function transformerRounds($scoreInRounds)
    {
        $this->setRounds(new ArrayCollection());

        if (empty($scoreInRounds)) {
            for ($i = 1; $i <= 5; $i++) {
                $round = new ScoreInRound();
                $round->setNameRound($i);
                $round->setHomeScore(0);
                $round->setGuestScore(0);
                $this->getRounds()->add($round);
            }
        } else {
            $rounds = explode(', ', $scoreInRounds);
            $i = 1;
            foreach ($rounds as $round) {
                $score = explode(':', $round);

                $scoreRound = new ScoreInRound();
                $scoreRound->setNameRound($i);
                $scoreRound->setHomeScore($score[0]);
                $scoreRound->setGuestScore($score[1]);
                $this->getRounds()->add($scoreRound);
                $i++;
            }

            for ($j = $i; $j <= 5; $j++) {
                $scoreRound = new ScoreInRound();
                $scoreRound->setNameRound($j);
                $scoreRound->setHomeScore(0);
                $scoreRound->setGuestScore(0);
                $this->getRounds()->add($scoreRound);
            }
        }
    }

    /**
     * @return ArrayCollection
     */
    public function getRounds()
    {
        return $this->rounds;
    }

    /**
     * @param ArrayCollection $rounds
     *
     * @return Event
     */
    public function setRounds($rounds)
    {
        $this->rounds = $rounds;

        return $this;
    }

    /**
     * Set season
     *
     * @param \Zenomania\CoreBundle\Entity\Season $season
     *
     * @return Event
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

    /**
     * @return ArrayCollection
     */
    public function getLineup()
    {
        return $this->lineup;
    }

    /**
     * @param ArrayCollection $lineup
     *
     * @return Event
     */
    public function setLineup(ArrayCollection $lineup)
    {
        $this->lineup = $lineup;

        return $this;
    }
}
