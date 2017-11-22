<?php
/**
 * @package    Zenomania\ApiBundle\Service\Afr\Handler
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service\Afr\Handler;

use Doctrine\Common\Collections\ArrayCollection;
use Zenomania\CoreBundle\Document\ProviderEvent;
use Zenomania\CoreBundle\Repository\Document\ProviderEventRepository;

class MatchesHandler
{
    /**
     * @var ProviderEventRepository
     */
    private $repository;

    public function __construct(ProviderEventRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Saves events to repository
     *
     * @param array $data
     */
    public function handle(array $data)
    {
        $collection = new ArrayCollection();
        foreach ($data as $item) {
            $event = ProviderEvent::fromArray($item);
            $collection->add($event);
        }

        $this->getRepository()->addIfNotExist($collection);
    }

    /**
     * @return ProviderEventRepository
     */
    public function getRepository(): ProviderEventRepository
    {
        return $this->repository;
    }
}