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
use Zenomania\CoreBundle\Entity\ScoreInRound;

class EventService
{
    /** @var EntityManager */
    private $em;

    /**
     * @var \Zenomania\CoreBundle\Repository\EventRepository
     */
    private $eventRepository;

    /**
     * @var \Zenomania\CoreBundle\Repository\LineUpRepository
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
        $this->getLineupRepository()->deleteAllByEventId($event->getId());

        foreach ($event->getLineup() as $line) {
            /** @var LineUp $line */
            if (empty($line->getPlayer())) {
                return false;
            }

            $line->setEvent($event);
            $this->getEm()->persist($line);
        }

        $event->setIsLineUp(true);
        $this->getEm()->flush();
        return true;
    }

    /**
     * @param Event $event
     */
    public function transformerRounds($event)
    {
        $event->setRounds(new ArrayCollection());

        if (empty($event->getScoreInRounds())) {
            for ($i = 1; $i <= 5; $i++) {
                $round = new ScoreInRound();
                $round->setNameRound($i);
                $round->setHomeScore(0);
                $round->setGuestScore(0);
                $event->getRounds()->add($round);
            }
        } else {
            $rounds = explode(', ', $event->getScoreInRounds());
            $i = 1;
            foreach ($rounds as $round) {
                $score = explode(':', $round);

                $scoreRound = new ScoreInRound();
                $scoreRound->setNameRound($i);
                $scoreRound->setHomeScore($score[0]);
                $scoreRound->setGuestScore($score[1]);
                $event->getRounds()->add($scoreRound);
                $i++;
            }

            for ($j = $i; $j <= 5; $j++) {
                $scoreRound = new ScoreInRound();
                $scoreRound->setNameRound($j);
                $scoreRound->setHomeScore(0);
                $scoreRound->setGuestScore(0);
                $event->getRounds()->add($scoreRound);
            }
        }
    }

    /**
     * Преобразует массив со счётом каждого раунда в строку, типа 25:21, 25:23, 25:20
     *
     * @param Event $event
     */
    public function reverseRounds($event)
    {
        $array = [];
        $score = [0 => 0, 1 => 0];
        foreach ($event->getRounds() as $round) {
            /** @var ScoreInRound $round */
            if (($round->getHomeScore() <= 15) && ($round->getGuestScore() <= 15)) {
                break;
            }

            (($round->getHomeScore() - $round->getGuestScore()) > 0) ? ($score[0]++) : ($score[1]++);
            $array[] = $round->getHomeScore() . ":" . $round->getGuestScore();
        }

        if (in_array(3, $score)) {
            $event->setScoreSaved(1);
        }

        $event->setScoreInRounds(implode(', ', $array));
    }

    /**
     * @return \Zenomania\CoreBundle\Repository\EventRepository
     */
    public function getEventRepository()
    {
        return $this->eventRepository;
    }

    /**
     * @return \Zenomania\CoreBundle\Repository\LineUpRepository
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