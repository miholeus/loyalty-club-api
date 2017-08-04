<?php

namespace Zenomania\CoreBundle\Form\Validators;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Zenomania\CoreBundle\Entity\User;

class UserConstraintValidator extends ConstraintValidator
{
    /**
     * Validates value to be user instance
     *
     * @param mixed $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if(!($value instanceof User)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
