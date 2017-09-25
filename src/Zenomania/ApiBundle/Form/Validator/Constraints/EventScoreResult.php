<?php
/**
 * @package    Zenomania\ApiBundle\Form\Validator\Constraints
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Form\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class EventScoreResult extends Constraint
{
    public $message = 'Общий счет указан неверно';
}