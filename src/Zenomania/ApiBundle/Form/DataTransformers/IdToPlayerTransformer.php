<?php
/**
 * @package    Zenomania\ApiBundle\Form\DataTransformers
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Form\DataTransformers;

use Doctrine\Common\Collections\Collection;
use Zenomania\CoreBundle\Form\DataTransformers\AbstractIdToEntityTransformer;
use Zenomania\CoreBundle\Service\Player;

class IdToPlayerTransformer extends AbstractIdToEntityTransformer
{
    /**
     * @var Player
     */
    private $service;

    /**
     * @param Player $service
     */
    public function __construct(Player $service)
    {
        $this->service = $service;
    }

    /**
     * @return Player
     */
    public function getService(): Player
    {
        return $this->service;
    }

    /**
     * @param Collection $collection
     * @return array
     */
    protected function getIdArray(Collection $collection)
    {
        return $collection->map(function ($player) {
            /** @var \Zenomania\CoreBundle\Entity\Player $player */
            return $player->getId();
        })->toArray();
    }

    /**
     * @param array $ids
     * @return \Zenomania\CoreBundle\Entity\Player[]
     */
    protected function getEntitiesByIds(array $ids)
    {
        return $this->getService()->getByIds($ids, Player::DEFAULT_CLUB_ID);
    }
}