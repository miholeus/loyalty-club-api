<?php
/**
 * @package    Zenomania\ApiBundle\Form\Model
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Form\Model;

use Zenomania\ApiBundle\Form\Validator\Constraints\{
    EventPlayer as AcmeEventPlayer
};
use Zenomania\CoreBundle\Entity\Event;
use Zenomania\CoreBundle\Entity\Player;

class EventPlayerPrediction
{
    /**
     * Scores by parties
     *
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @AcmeEventPlayer()
     */
    protected $players;
    /**
     * MVP player
     *
     * @var Player
     */
    protected $mvp;

    /**
     * @var Event
     */
    protected $event;
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $forecasts;

    public function __construct()
    {
        $this->players = new \Doctrine\Common\Collections\ArrayCollection();
        $this->forecasts = new \Doctrine\Common\Collections\ArrayCollection();
    }
    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * @param Player $player
     */
    public function addPlayer(Player $player)
    {
        $this->players[] = $player;
    }
    /**
     * @param array $players
     */
    public function setPlayers(array $players)
    {
        foreach ($players as $player) {
            $this->addPlayer($player);
        }
    }

    /**
     * @return Player
     */
    public function getMvp()
    {
        return $this->mvp;
    }

    /**
     * @param Player $mvp
     */
    public function setMvp(Player $mvp)
    {
        $this->mvp = $mvp;
    }

    /**
     * @return Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param Event $event
     */
    public function setEvent(Event $event)
    {
        $this->event = $event;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getForecasts(): \Doctrine\Common\Collections\ArrayCollection
    {
        return $this->forecasts;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $forecasts
     */
    public function setForecasts(\Doctrine\Common\Collections\ArrayCollection $forecasts)
    {
        $this->forecasts = $forecasts;
    }
}