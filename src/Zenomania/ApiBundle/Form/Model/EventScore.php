<?php
/**
 * @package    Zenomania\ApiBundle\Form\Model
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Zenomania\ApiBundle\Form\Validator\Constraints\EventScore as ScoreAssert;

class EventScore
{
    /**
     * @var string
     * @Assert\NotBlank()
     * @ScoreAssert()
     */
    protected $score;

    /**
     * @return mixed
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @param mixed $score
     */
    public function setScore($score)
    {
        $this->score = $score;
    }
}