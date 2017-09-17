<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 15.09.17
 * Time: 17:05
 */

namespace Zenomania\ApiBundle\Form\DataTransformers;

use \Zenomania\CoreBundle\Entity\District;
use Symfony\Component\Form\DataTransformerInterface;
class IdToDistrictObjectTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        $city = new District();
        return $city->setId((int)$value);
    }

    public function reverseTransform($value)
    {
        return $value;
    }

}