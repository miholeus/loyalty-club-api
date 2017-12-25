<?php
/**
 * Created by PhpStorm.
 * User: igorvolkov
 * Date: 26.12.2017
 * Time: 0:48
 */

namespace Zenomania\ApiBundle\Service\Transformer;


use Zenomania\CoreBundle\Entity\Payment;
use Zenomania\CoreBundle\Service\Utils\HostBasedUrl;

class PaymentTransformer extends TransformerAbstract
{
    /**
     * @var HostBasedUrl
     */
    private $url;

    public function __construct(HostBasedUrl $url)
    {
        $this->url = $url;
    }

    public function transform(Payment $payment)
    {
        $data = [
            'id' => $payment->getId(),
            'amount' => $payment->getAmount(),
            'type' => $payment->getType(),
            'createdOn' => $payment->getCreatedOn()->format('Y-m-d'),
            'userId' => $payment->getUser()->getId(),
        ];
        return $data;
    }
}