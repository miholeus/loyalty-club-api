<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 28.09.17
 * Time: 15:00
 */

namespace Zenomania\ApiBundle\Service\Transformer;

class RatingsTransformer extends TransformerAbstract
{
    public function transform(array $items)
    {
        $data = array();
        foreach ($items as $key => $value){
            $item['position'] = $value['position'];
            $item['points'] = $value['points'];
            $item['user_id'] = $value['user_id'];
            $item['avatar'] = $value['avatar'];
            $item['firstname'] = $value['firstname'];
            $item['lastname'] = $value['lastname'];
            $item['middlename'] = $value['middlename'];
            $data[] = $item;
        }
        return $data;
    }
}