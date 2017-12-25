<?php
/**
 * @package    Zenomania\CoreBundle\Repository\Document
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\CoreBundle\Repository\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Zenomania\CoreBundle\Document\ProviderSubscription;

class ProviderSubscriptionRepository extends DocumentRepository
{
    public function addIfNotExist(ArrayCollection $collection)
    {
        /** @var ProviderSubscription $subscription */
        foreach ($collection as $subscription) {
            if (!$this->exists($subscription->getSubId())) {
                $this->dm->persist($subscription);
            }
        }
        $this->dm->flush();
    }

    /**
     * @param ProviderSubscription $document
     * @param $status
     */
    public function updateStatus(ProviderSubscription $document, $status)
    {
        $document->setStatus($status);
        $document->setUpdatedOn(new \DateTime());
        $this->dm->persist($document);
        $this->dm->flush();
    }
    /**
     * Checks if event id already exists
     *
     * @param int $subId
     * @return bool
     */
    protected function exists(int $subId): bool
    {
        $result = $this->getDocumentManager()->createQueryBuilder('ZenomaniaCoreBundle:ProviderSubscription')
            ->field('sub_id')->equals($subId)->count()->getQuery()->execute();

        return $result !== 0;
    }
}