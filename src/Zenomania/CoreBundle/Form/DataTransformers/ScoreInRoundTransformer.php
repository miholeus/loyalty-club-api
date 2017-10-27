<?php
/**
 * @package    Zenomania\CoreBundle\Form\DataTransformers
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\CoreBundle\Form\DataTransformers;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Zenomania\CoreBundle\Entity\Event;
use Zenomania\CoreBundle\Form\Model\ScoreInRound;

class ScoreInRoundTransformer implements DataTransformerInterface
{
    public function transform($value)
    {

        if(null === $value) {
            return '';
        } else if($value instanceof \Zenomania\CoreBundle\Entity\Event) {

            /** @var Event $event */
            $event = $value;

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
                $rounds = explode(',', $event->getScoreInRounds());
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

            return $event;
        } else {
            throw new TransformationFailedException();
        }
    }

    public function reverseTransform($value)
    {
        if($value instanceof \Zenomania\CoreBundle\Entity\Event) {
            $event = $value;

            $scoreInRounds = [];
            $score = [0 => 0, 1 => 0];

            foreach ($event->getRounds() as $round) {
                /** @var ScoreInRound $round */
                if (($round->getHomeScore() <= 15) && ($round->getGuestScore() <= 15)) {
                    break;
                }

                (($round->getHomeScore() - $round->getGuestScore()) > 0) ? ($score[0]++) : ($score[1]++);
                $scoreInRounds[] = $round->getHomeScore() . ":" . $round->getGuestScore();
            }

            if (in_array(3, $score)) {
                $event->setScoreSaved(1);
            }

            $event->setScoreInRounds(implode(',', $scoreInRounds));

            return $event;
        } else {
            throw new TransformationFailedException();
        }
    }
}