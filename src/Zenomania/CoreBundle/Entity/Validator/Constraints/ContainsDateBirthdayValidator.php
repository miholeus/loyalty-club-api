<?php

namespace Zenomania\CoreBundle\Entity\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ContainsDateBirthdayValidator extends ConstraintValidator
{
    const BIRTHDAY_MIN_DATE = '1900-01-01';

    public function validate($value, Constraint $constraint)
    {
        if ($value) {
            $minDate = new \DateTime(self::BIRTHDAY_MIN_DATE);
            $maxDate = new \DateTime();
            if ($value < $minDate || $value > $maxDate) {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('%fieldname%', "birth_date")
                    ->setParameter('%minDate%', $minDate->format('d.m.Y'))
                    ->setParameter('%maxDate%', $maxDate->format('d.m.Y'))
                    ->addViolation();
            }
        }
    }
}