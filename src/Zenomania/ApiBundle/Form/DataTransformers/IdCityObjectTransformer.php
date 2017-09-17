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
use Symfony\Component\Form\Exception\TransformationFailedException;


class IdCityObjectTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        if(null === $value) {
            return '';
        } else if($value instanceof \Zenomania\CoreBundle\Entity\City) {
            return $value->getId();
        } else {
            throw new TransformationFailedException();
        }
    }

    public function reverseTransform($value)
    {
        if (null === $value) {
            return new City();
        } else if (is_numeric($value)) {
            $city = new City();
            $city->setId($value);
            return $city;
        } else {
            throw new TransformationFailedException();
        }
    }
}