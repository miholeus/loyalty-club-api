<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 30.10.2017
 * Time: 16:55
 */

namespace Zenomania\CoreBundle\Service;


use Doctrine\ORM\EntityManager;
use Zenomania\CoreBundle\Repository\SubscriptionRepository;

class SubscriptionService
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var SubscriptionRepository
     */
    private $subscriptionRepository;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->subscriptionRepository = $em->getRepository('ZenomaniaCoreBundle:Subscription');
    }


    public function addFromFile($data)
    {
        $result = ['new' => 0, 'duplicate' => 0, 'error' => 0];
        foreach ($data as $row) {

            $place = explode(' ', $row[0]);
            $sectorPlace = $place[1];
            $rowPlace = $place[3];
            $seatPlace = $place[5];
            $number = trim($row[1]);
            $mifare = trim($row[2]);
            $price = str_replace(' ', '', $row[3]);

            if (empty($number)) {
                $result['error']++;
                continue;
            }

            $subscription = $this->getSubscriptionRepository()->findSubsByMifare($mifare);
            if (!empty($subscription)) {
                $result['duplicate']++;
                continue;
            }

            //echo $sectorPlace . ' - ' . $rowPlace . ' - ' . $seatPlace . ' - ' . $number . ' - ' . $mifare . ' - ' . $price . PHP_EOL;

        }
    }

    /**
     * @return EntityManager
     */
    public function getEm(): EntityManager
    {
        return $this->em;
    }

    /**
     * @return SubscriptionRepository
     */
    public function getSubscriptionRepository()
    {
        return $this->subscriptionRepository;
    }
}