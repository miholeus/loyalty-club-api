<?php

namespace Zenomania\CoreBundle\Form\Constraints;

use Symfony\Component\Validator\Constraint;
use Zenomania\CoreBundle\Form\Validators\UserConstraintValidator;

class UserConstraint extends Constraint
{
    public $message = "Пользователь не существует";

    public function __construct($message = null)
    {
        if($message) {
            $this->message = $message;
        }
    }

    public function validatedBy()
    {
        return UserConstraintValidator::class;
    }
}
