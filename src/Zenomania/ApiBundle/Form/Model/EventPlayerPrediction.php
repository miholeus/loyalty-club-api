<?php
/**
 * @package    Zenomania\ApiBundle\Form\Model
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Form\Model;

use Zenomania\ApiBundle\Form\Validator\Constraints\{
    EventPlayer as AcmeEventPlayer
};
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

    public function __construct()
    {
        $this->players = new \Doctrine\Common\Collections\ArrayCollection;
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
}