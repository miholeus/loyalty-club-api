<?php
/**
 * @package    Zenomania\ApiBundle\Form\Validator\Constraints
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Form\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class EventPlayerValidator extends ConstraintValidator
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
                    throw new \InvalidArgumentException("Выберите стартовый состав");
                }
                if ($value->count() != 6) {
                    throw new \InvalidArgumentException("Нужно указать 6 игроков в стартовом составе");
                }
            } catch (\InvalidArgumentException $e) {
                $this->context->buildViolation($e->getMessage())
                    ->addViolation();
            }
        }
    }

}