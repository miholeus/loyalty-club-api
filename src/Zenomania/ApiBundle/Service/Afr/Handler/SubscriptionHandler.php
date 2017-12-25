<?php
/**
 * @package    Zenomania\ApiBundle\Service\Afr\Handler
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service\Afr\Handler;

use Doctrine\Common\Collections\ArrayCollection;
use Zenomania\CoreBundle\Document\ProviderSubscription;
use Zenomania\CoreBundle\Repository\Document\ProviderSubscriptionRepository;
use Zenomania\CoreBundle\Repository\SubscriptionRepository;

class SubscriptionHandler
{
    /**
     * @var ProviderSubscriptionRepository
     */
    private $repository;
    /**
     * @var SubscriptionRepository
     */
    private $subscriptionRepository;

    /**
     * @var \Closure
     */
    private $logger;

    public function __construct(ProviderSubscriptionRepository $repository, SubscriptionRepository $subscriptionRepository)
    {
        $this->repository = $repository;
        $this->subscriptionRepository = $subscriptionRepository;
    }


    public function attachLogger(\Closure $closure)
    {
        $this->logger = $closure;
    }

    protected function log($message)
    {
        if (null === $this->logger) {
            return;
        }
        call_user_func($this->logger, $message);
    }

    /**
     * Saves subs to repository
     *
     * @param array $data
     * @param int $seasonId
     */
    public function saveToStorage(array $data, int $seasonId)
    {
        $collection = new ArrayCollection();
        foreach ($data as $item) {
            $event = ProviderSubscription::fromArray($item);
            $event->setSeasonId($seasonId);
            $collection->add($event);
        }

        $this->getRepository()->addIfNotExist($collection);
    }

    /**
     * Returns new subs
     *
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getNewSubs($limit = 1000, $offset = 0)
    {
        return $this->getRepository()->findBy(["status" => ProviderSubscription::STATUS_NEW], ["date" => "ASC"], $limit, $offset);
    }

    /**
     * Handles subscriptions
     *
     * @param array $subs
     */
    public function handle(array $subs)
    {
        $repo = $this->getSubscriptionRepository();
        /** @var ProviderSubscription $subscription */
        foreach ($subs as $subscription) {
            try {
                $data = $subscription->toArray();
                $localId = $repo->addIfNotExists($data);
                $this->getRepository()->updateStatus($subscription, ProviderSubscription::STATUS_DONE);

                $this->log(sprintf("<info>Updated subscription %d, local id %d</info>", $subscription->getSubId(), $localId));
            } catch (\Exception $e) {
                $this->getRepository()->updateStatus($subscription, ProviderSubscription::STATUS_ERROR);
                $this->log(sprintf("<error>subscription %d: %s</error>", $subscription->getSubId(), $e->getMessage()));
            }
        }
    }

    /**
     * @return SubscriptionRepository
     */
    public function getSubscriptionRepository(): SubscriptionRepository
    {
        return $this->subscriptionRepository;
    }

    /**
     * @return ProviderSubscriptionRepository
     */
    public function getRepository(): ProviderSubscriptionRepository
    {
        return $this->repository;
    }
}