<?php
/**
 * @package    Zenomania\ApiBundle\Form\Model
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Zenomania\ApiBundle\Form\Validator\Constraints\EventScoreResult;

class EventScorePrediction
{
    /**
     * Final score result
     *
     * @var string
     * @Assert\NotBlank()
     * @EventScoreResult()
     */
    protected $result;
    /**
     * Scores by parties
     *
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $scores;

    public function __construct()
    {
        $this->scores = new \Doctrine\Common\Collections\ArrayCollection;
    }

    /**
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param string $result
     */
    public function setResult(string $result)
    {
        $this->result = $result;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getScores()
    {
        return $this->scores;
    }

    /**
     * @param EventScore $score
     * @return $this
     * @internal param mixed $scores
     */
    public function addScore(EventScore $score)
    {
        $this->scores[] = $score;
        return $this;
    }

    /**
     * Sets scores
     *
     * @param array $scores
     */
    public function setScores(array $scores)
    {
        foreach ($scores as $score) {
            $this->addScore($score);
        }
    }
    /**
     * @param EventScore $score
     * @return $this
     */
    public function removeScores(EventScore $score)
    {
        $this->scores->removeElement($score);
        return $this;
    }
}