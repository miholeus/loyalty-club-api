<?php

namespace Zenomania\CoreBundle\Entity\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ContainsDateBirthday extends Constraint
{
    public $message = 'The field "%fieldname%" must be greater then "%minDate%" and less then "%maxDate%"';
}