<?php
/**
 * @package    Zenomania\ApiBundle\Service\Prediction
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service\Prediction;

use Zenomania\CoreBundle\Repository\PersonPointsRepository;

class AbstractPrediction
{
    /**
     * @var PersonPointsRepository
     */
    private $repository;

    public function __construct(PersonPointsRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return PersonPointsRepository
     */
    public function getRepository(): PersonPointsRepository
    {
        return $this->repository;
    }
}