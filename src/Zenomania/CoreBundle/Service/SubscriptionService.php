<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 30.10.2017
 * Time: 16:55
 */

namespace Zenomania\CoreBundle\Service;


use Doctrine\ORM\EntityManager;
use Zenomania\CoreBundle\Entity\Subscription;
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


    /**
     * @param $data
     * @return array
     */
    public function addFromFile($data)
    {
        $result = ['new' => 0, 'duplicate' => 0, 'error' => 0];
        foreach ($data as $row) {

            $place = explode(' ', trim($row['Place']));
            $sectorPlace = $place[1];
            $rowPlace = $place[3];
            $seatPlace = $place[5];
            $number = $this->getNumber($row['Number']);
            $mifare = trim($row['Mifare']);
            $price = str_replace(' ', '', $row['Price']);

            if (empty($number)) {
                $result['error']++;
                echo 'Нет номера' . PHP_EOL;
                continue;
            }

            if (false === strpos($mifare, 'Mifare')) {
                $result['error']++;
                echo 'Нет Mifare в коде абонемента ' . $mifare . PHP_EOL;
                continue;
            }

            $subscription = $this->getSubscriptionRepository()->findSubsByMifare($mifare);
            if (!empty($subscription)) {
                $result['duplicate']++;
                echo 'Такой абонемент уже есть в базе' . PHP_EOL;
                continue;
            }

            $params = [
                'mifare' => $mifare,
                'number' => $number,
                'sector' => $sectorPlace,
                'row' => $rowPlace,
                'seat' => $seatPlace,
                'price' => $price,
            ];

            // Сохраняем абонемент в базу
            $subscription = Subscription::fromArray($params);
            $this->getSubscriptionRepository()->save($subscription);
            $result['new']++;

            echo 'Добавили абонемент в базу ' . $number . PHP_EOL;
        }

        return $result;
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

    /**
     * Разбираем строку и формируем номер абонемента, который написан на карточке
     * Если номер абонемента начинается на АБ, то число дополняем до 4-х значного
     * ведущими нулями, типа АБ 3 => АБ0003
     *
     * @param $number
     * @return string
     */
    private function getNumber($number): string
    {
        $number = trim($number);

        $numberPart = explode(' ', $number);
        if ('АБ' == $numberPart[0]) {
            $number = $numberPart[0] . str_pad($numberPart[1], 4, '0', STR_PAD_LEFT);
        } else {
            $number = implode('', $numberPart);
        }

        return $number;
    }
}