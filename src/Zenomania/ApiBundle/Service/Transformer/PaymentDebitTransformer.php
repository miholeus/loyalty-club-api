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

class PaymentDebitTransformer extends TransformerAbstract
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
        ];
        return $data;
    }
}