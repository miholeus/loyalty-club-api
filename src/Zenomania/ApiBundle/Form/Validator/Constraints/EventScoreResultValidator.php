<?php
/**
 * @package    Zenomania\ApiBundle\Form\Validator\Constraints
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Form\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class EventScoreResultValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if ($value) {
            $result = explode(':', $value);
            $result = array_map('intval', $result);
            try {
                if (count($result) != 2) {
                    throw new \InvalidArgumentException("В общем счете должны быть указаны 2 значения");
                } else {
                    if ($result[0] == $result[1]) {
                        throw new \InvalidArgumentException($constraint->message);
                    }
                }

                $max = max($result);
                $min = min($result);

                if ($max > 3) {
                    throw new \InvalidArgumentException("Общий счет не может быть больше 3х");
                }

                if ($min <= 0 || $max != 3) {
                    throw new \InvalidArgumentException($constraint->message);
                }
            } catch (\InvalidArgumentException $e) {
                $this->context->buildViolation($e->getMessage())
                    ->addViolation();
            }
        }
    }
}