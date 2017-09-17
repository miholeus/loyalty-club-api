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
        if (null === $value) {
            return '';
        } else if ($value instanceof \Zenomania\CoreBundle\Entity\District) {
            return $value->getId();
        } else {
            throw new TransformationFailedException();
        }
    }

    public function reverseTransform($value)
    {
        if (null === $value) {
            return new District();
        } else if (is_numeric($value)) {
            $city = new District();
            $city->setId($value);
            return $city;
        } else {
            throw new TransformationFailedException();
        }
    }

}