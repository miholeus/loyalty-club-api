<?php
/**
 * @package    Zenomania\ApiBundle\Form\Validator\Constraints
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Form\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class EventScoreValidator extends ConstraintValidator
{
    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if ($value) {
            try {
                if ($value->count() == 0) {
                    throw new \InvalidArgumentException("Укажите несколько партий");
                }
                if ($value->count() < 3) {
                    throw new \InvalidArgumentException("Нужно указать счет как минимум в трех партиях");
                }
                if ($value->count() > 5) {
                    throw new \InvalidArgumentException("Нельзя указывать счет более, чем в пяти партиях");
                }

                /** @var \Zenomania\ApiBundle\Form\Model\EventScore $score */
                $round = 1;
                $teamWins = [1 => 0, 2 => 0];
                foreach ($value as $score) {
                    $scoreValues = explode(":", $score->getScore());
                    if (count($scoreValues) != 2) {
                        throw new \InvalidArgumentException("Неверно указан счет");
                    }

                    if ($teamWins[1] == 3 || $teamWins[2] == 3) {
                        throw new \InvalidArgumentException("Команды играют до 3х побед в партиях");
                    }
                    $max = max($scoreValues);
                    $min = min($scoreValues);

                    $maximumScores = $round != 5 ? 25 : 15;

                    // играют до 15/25 очков в партиях
                    if ($max < $maximumScores) {
                        throw new \InvalidArgumentException(sprintf("Счет в партии %d должен быть %d или более", $round, $maximumScores));
                    }

                    if ($max == $maximumScores) {
                        if ($max - $min < 2) {
                            throw new \InvalidArgumentException(sprintf("Счет в партии %d указан неверно", $round));
                        }
                    } else {
                        if ($max - $min != 2) {
                            throw new \InvalidArgumentException(sprintf("Счет в партии %d указан неверно", $round));
                        }
                    }

                    if ($scoreValues[0] > $scoreValues[1]) {
                        $teamWins[1]++;
                    } else {
                        $teamWins[2]++;
                    }
                    $round++;
                }
            } catch (\InvalidArgumentException $e) {
                $this->context->buildViolation($e->getMessage())
                    ->addViolation();
            }
        }
    }

}