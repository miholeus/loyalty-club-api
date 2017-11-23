<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 22.11.17
 * Time: 15:08
 */

namespace Zenomania\ApiBundle\Service;


use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Zenomania\ApiBundle\Form\Model\Order as OrderModel;
use Zenomania\CoreBundle\Entity\OrderCart;
use Zenomania\CoreBundle\Entity\Product;

class OrderCartService
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * OrderCartService constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function parseOrderCarts(OrderModel $order)
    {
        $data = $order->getOrderCart();
        $orderCarts = array();
        $tmp = array();

        //Группируем все товары
        /** @var OrderCart $item */
        foreach ($data as $item) {
            if (!array_key_exists($item->getProductId(), $tmp)) {
                $tmp[$item->getProductId()] = $item;
            } else {
                /** @var OrderCart $product */
                $product = $tmp[$item->getProductId()];
                $product->setQuantity($product->getQuantity() + $item->getQuantity());
            }
        }

        $data = $tmp;

        foreach ($data as $item) {
            /** @var Product $product */
            $product = $this->getEm()->find('ZenomaniaCoreBundle:Product', $item->getProductId());

            if ($product == null) {
                throw new HttpException(404, "Товар не найден");
            }

            if ($product->getQuantity() < $item->getQuantity()) {
                throw new HttpException(400, "Товар закончился");
            }

            $orderCart = new OrderCart();
            $orderCart->setCreatedAt(new \DateTime());
            $orderCart->setProductId($product);
            $orderCart->setPrice($product->getPrice());
            $orderCart->setQuantity($item->getQuantity());
            $orderCart->setTotalPrice($orderCart->getPrice() * $orderCart->getQuantity());
            $orderCarts[] = $orderCart;
        }
        return $orderCarts;
    }

    /**
     * @return EntityManager
     */
    public function getEm()
    {
        return $this->em;
    }
}