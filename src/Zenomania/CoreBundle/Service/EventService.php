<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 22.09.2017
 * Time: 16:40
 */

namespace Zenomania\CoreBundle\Service;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Zenomania\CoreBundle\Entity\Event;
use Zenomania\CoreBundle\Entity\LineUp;

class EventService
{
    /** @var EntityManager */
    private $em;

    /**
     * @var \Zenomania\CoreBundle\Repository\EventRepository
     */
    private $eventRepository;

    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $lineupRepository;

    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $playerRepository;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->eventRepository = $em->getRepository('ZenomaniaCoreBundle:Event');
        $this->lineupRepository = $em->getRepository('ZenomaniaCoreBundle:LineUp');
        $this->playerRepository = $em->getRepository('ZenomaniaCoreBundle:Player');
    }

    /**
     * @param Event $event
     */
    public function transformerLineup($event)
    {
        $event->setLineup(new ArrayCollection());

        /** @var LineUp[] $lineupModel */
        $lineupModel = $this->getLineupRepository()->findBy(['event' => $event]);

        if (empty($lineupModel)) {
            for ($i = 1; $i <= 6; $i++) {
                $lineup = new LineUp();
                $lineup->setEvent($event);
                $event->getLineup()->add($lineup);
            }
        } else {
            $i = 1;
            foreach ($lineupModel as $player) {
                /** @var LineUp $player */
                $lineup = new LineUp();
                $lineup->setEvent($event);
                $lineup->setPlayer($player->getPlayer());
                $event->getLineup()->add($lineup);
                $i++;
            }

            for ($j = $i; $j <= 6; $j++) {
                $lineup = new LineUp();
                $lineup->setEvent($event);
                $event->getLineup()->add($lineup);
            }
        }
    }

    /**
     * @param Event $event
     * @return bool
     */
    public function reverseLineup($event)
    {
        foreach ($event->getLineup() as $line) {
            /** @var LineUp $line */
            if (empty($line->getPlayer())) {
                return false;
            }

            $line->setEvent($event);
            $this->getEm()->persist($line);
        }

        $this->getEm()->flush();
        return true;
    }

    /**
     * @return \Zenomania\CoreBundle\Repository\EventRepository
     */
    public function getEventRepository()
    {
        return $this->eventRepository;
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getLineupRepository()
    {
        return $this->lineupRepository;
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getPlayerRepository()
    {
        return $this->playerRepository;
    }

    /**
     * @return EntityManager
     */
    public function getEm(): EntityManager
    {
        return $this->em;
    }
}