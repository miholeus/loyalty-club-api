<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 11.09.2017
 * Time: 15:59
 */

namespace Zenomania\CoreBundle\Entity;


class LineUp
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Zenomania\CoreBundle\Entity\Event
     */
    private $event;

    /**
     * @var \Zenomania\CoreBundle\Entity\Player
     */
    private $player;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \Zenomania\CoreBundle\Entity\Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param \Zenomania\CoreBundle\Entity\Event $event
     */
    public function setEvent(\Zenomania\CoreBundle\Entity\Event $event = null)
    {
        $this->event = $event;
    }

    /**
     * @return \Zenomania\CoreBundle\Entity\Player
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * @param \Zenomania\CoreBundle\Entity\Player $player
     */
    public function setPlayer(\Zenomania\CoreBundle\Entity\Player $player = null)
    {
        $this->player = $player;
    }
}