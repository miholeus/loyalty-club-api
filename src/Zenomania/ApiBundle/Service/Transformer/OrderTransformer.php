<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 24.11.17
 * Time: 10:45
 */

namespace Zenomania\ApiBundle\Service\Transformer;


use Zenomania\CoreBundle\Entity\Order;
use Zenomania\CoreBundle\Entity\OrderCart;
use Zenomania\CoreBundle\Entity\OrderDelivery;
use Zenomania\CoreBundle\Service\Utils\HostBasedUrl;

class OrderTransformer extends TransformerAbstract
{
    /**
     * @var HostBasedUrl
     */
    private $url;

    public function __construct(HostBasedUrl $url)
    {
        $this->url = $url;
    }

    /**
     * Transforms order
     *
     * @param array $data
     * @return array
     */
    public function transform(array $data)
    {
        /** @var Order $order */
        $order = $data['order'];

        /** @var OrderDelivery $orderDelivery */
        $orderDelivery = $data['orderDelivery'];
        $items = array();
        foreach ($data['orderCart'] as $item){
            $product = array();
            /** @var OrderCart $item */
            $product['id'] = $item->getId();
            $product['title'] = $item->getProductId()->getTitle();
            $product['quantity'] = $item->getQuantity();
            $items[] = $product;
        }

        return [
            'id' => $order->getId(),
            'items' => $items,
            'dt' => $order->getCreatedAt()->format('Y-m-d h:i:s'),
            'status' => $order->getStatusId()->getTitle(),
            'name' => $orderDelivery->getClientName(),
            'delivery_type' => $orderDelivery->getDeliveryTypeId()->getTitle(),
            'address' => $orderDelivery->getAddress(),
            'phone' => $orderDelivery->getPhone(),
        ];
    }
}