<?php
/**
 * @package    Zenomania\ApiBundle\Form\Model
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Zenomania\ApiBundle\Form\Validator\Constraints\{
    EventScoreResult as AcmeEventScoreResult,
    EventScore as AcmeEventScore
};

class EventScorePrediction
{
    /**
     * Final score result
     *
     * @var string
     * @Assert\NotBlank()
     * @AcmeEventScoreResult()
     */
    protected $result;
    /**
     * Scores by parties
     *
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @AcmeEventScore()
     */
    protected $scores;

    public function __construct()
    {
        $this->scores = new \Doctrine\Common\Collections\ArrayCollection;
    }

    /**
     * Returns all scores in a string
     *
     * @return string
     */
    public function getScoreInRounds() : string
    {
        $scores = [];
        /** @var EventScore $score */
        foreach ($this->getScores() as $score) {
            $value = $score->getScore();
            $scores[] = $value;
        }
        return join(',', $scores);
    }
    /**
     * Returns scores for club on home event
     *
     * @return integer
     */
    public function getScoreHome()
    {
        $values = explode(":", $this->getResult());
        return intval($values[0]);
    }

    /**
     * Returns scores for club on guest event
     *
     * @return integer
     */
    public function getScoreGuest()
    {
        $values = explode(":", $this->getResult());
        return intval($values[1]);
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