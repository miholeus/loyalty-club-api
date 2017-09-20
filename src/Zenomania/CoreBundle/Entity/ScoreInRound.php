<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 20.09.2017
 * Time: 13:01
 */

namespace Zenomania\CoreBundle\Entity;


class ScoreInRound
{

    private $nameRound;

    private $homeScore;

    private $guestScore;

    /**
     * @return mixed
     */
    public function getNameRound()
    {
        return $this->nameRound;
    }

    /**
     * @param mixed $nameRound
     */
    public function setNameRound($nameRound)
    {
        $this->nameRound = $nameRound;
    }

    /**
     * @return mixed
     */
    public function getHomeScore()
    {
        return $this->homeScore;
    }

    /**
     * @param mixed $homeScore
     */
    public function setHomeScore($homeScore)
    {
        $this->homeScore = $homeScore;
    }

    /**
     * @return mixed
     */
    public function getGuestScore()
    {
        return $this->guestScore;
    }

    /**
     * @param mixed $guestScore
     */
    public function setGuestScore($guestScore)
    {
        $this->guestScore = $guestScore;
    }

}