<?php
/**
 * @package    Zenomania\ApiBundle\Service\Afr\Handler
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service\Afr\Handler;

use Doctrine\Common\Collections\ArrayCollection;
use Monolog\Logger;
use Zenomania\CoreBundle\Document\ProviderEvent;
use Zenomania\CoreBundle\Repository\Document\ProviderEventRepository;

class MatchesHandler
{
    /**
     * @var Logger
     */
    private $logger;
    /**
     * @var ProviderEventRepository
     */
    private $repository;

    public function __construct(Logger $logger, ProviderEventRepository $repository)
    {
        $this->logger = $logger;
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
     * @return Logger
     */
    public function getLogger(): Logger
    {
        return $this->logger;
    }

    /**
     * @return ProviderEventRepository
     */
    public function getRepository(): ProviderEventRepository
    {
        return $this->repository;
    }
}