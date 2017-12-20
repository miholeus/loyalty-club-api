<?php
/**
 * Created by PhpStorm.
 * User: igorvolkov
 * Date: 19.12.2017
 * Time: 18:36
 */

namespace Zenomania\ApiBundle\Service;

use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Repository\OrderRepository;

class Prize
{

    /**
     * @var OrderRepository
     */
    private $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function getPrizes(User $user)
    {
        return $this->getOrderRepository()->getPrizes($user);

    }

    /**
     * @return OrderRepository
     */
    public function getOrderRepository(): OrderRepository
    {
        return $this->orderRepository;
    }
}