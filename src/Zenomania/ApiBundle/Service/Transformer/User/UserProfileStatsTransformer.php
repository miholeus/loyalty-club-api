<?php
/**
 * @package    Zenomania\ApiBundle\Service\Transformer\User
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */


namespace Zenomania\ApiBundle\Service\Transformer\User;


use Zenomania\ApiBundle\Service\Transformer\TransformerAbstract;
use Zenomania\CoreBundle\Entity\PersonPoints;
use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Repository\PersonPointsRepository;

class UserProfileStatsTransformer extends TransformerAbstract
{
    /**
     * @var PersonPointsRepository
     */
    private $repository;

    public function __construct(PersonPointsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function transform(User $user)
    {
        $data = $this->getRepository()->getUserPointsByType($user);

        $matches = 0;
        if (isset($data[PersonPoints::TYPE_TICKET_REGISTER])) {
            $matches += $data[PersonPoints::TYPE_TICKET_REGISTER];
        }
        if (isset($data[PersonPoints::TYPE_SUBSCRIPTION_REGISTER])) {
            $matches += $data[PersonPoints::TYPE_SUBSCRIPTION_REGISTER];
        }
        return [
            'matches' => $matches,
            'purchases' => $data[PersonPoints::TYPE_PURCHASE] ?? 0,
            'predictions' => $data[PersonPoints::TYPE_FORECAST_WINNER] ?? 0,
            'reposts' => $data[PersonPoints::TYPE_REPOST] ?? 0,
            'invites' => $data[PersonPoints::TYPE_INVITE] ?? 0
        ];
    }

    /**
     * @return PersonPointsRepository
     */
    public function getRepository(): PersonPointsRepository
    {
        return $this->repository;
    }
}