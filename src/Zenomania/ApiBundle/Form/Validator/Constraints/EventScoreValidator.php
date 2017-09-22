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
    public function validate($value, Constraint $constraint)
    {
        if ($value) {
            var_dump($value);
            die;
        }
    }

}