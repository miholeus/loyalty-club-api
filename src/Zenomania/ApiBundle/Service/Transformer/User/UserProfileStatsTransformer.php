<?php
/**
 * @package    Zenomania\ApiBundle\Service\Transformer\User
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */


namespace Zenomania\ApiBundle\Service\Transformer\User;


use Zenomania\ApiBundle\Service\Transformer\TransformerAbstract;
use Zenomania\CoreBundle\Entity\PersonPoints;

class UserProfileStatsTransformer extends TransformerAbstract
{
    public function transform(array $data)
    {
        $matches = 0;
        if (isset($data[PersonPoints::TYPE_TICKET_REGISTER])) {
            $matches += $data[PersonPoints::TYPE_TICKET_REGISTER];
        }
        if (isset($data[PersonPoints::TYPE_SUBSCRIPTION_REGISTER])) {
            $matches += $data[PersonPoints::TYPE_SUBSCRIPTION_REGISTER];
        }
        return [
            'matches' => $matches,
            'purchases' => $data[PersonPoints::TYPE_PURCHASE] ?? 0,
            'predictions' => $data[PersonPoints::TYPE_FORECAST_WINNER] ?? 0,
            'reposts' => $data[PersonPoints::TYPE_REPOST] ?? 0,
            'invites' => $data[PersonPoints::TYPE_INVITE] ?? 0,
            'promocoupons' => $data[PersonPoints::TYPE_PROMO_COUPON] ?? 0
        ];
    }
}