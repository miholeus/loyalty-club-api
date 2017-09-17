<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 15.09.17
 * Time: 17:00
 */

namespace Zenomania\ApiBundle\Form\DataTransformers;

use \Zenomania\CoreBundle\Entity\City;
use Symfony\Component\Form\DataTransformerInterface;

class IdCityObjectTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        $city = new City();
        return $city->setId((int)$value);
    }

    public function reverseTransform($value)
    {
        return $value;
    }
}