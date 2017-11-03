<?php
/**
 * @package    Zenomania\CoreBundle\Form\DataTransformers
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\CoreBundle\Form\DataTransformers;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Zenomania\CoreBundle\Entity\Event;
use Zenomania\CoreBundle\Entity\LineUp;

class LineUpTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        if(null === $value) {
            return '';
        } else if($value instanceof \Zenomania\CoreBundle\Entity\Event) {

            /** @var Event $event */
            $event = $value;

            $lineUps = $event->getLineUp();

            if ($lineUps->count() == 0) {
                for ($i = 1; $i <= 6; $i++) {
                    $lineup = new LineUp();
                    $event->addLineUp($lineup);
                }
            } else {
                for ($j = $lineUps->count()+1; $j <= 6; $j++) {
                    $lineup = new LineUp();
                    $event->addLineUp($lineup);
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

            foreach ($event->getLineup() as $line) {
                /** @var LineUp $line */
                if (empty($line->getPlayer())) {
                    $event->removeLineUp($line);
                } else {
                    $line->setEvent($event);
                }
            }

            return $event;
        } else {
            throw new TransformationFailedException();
        }
    }

}