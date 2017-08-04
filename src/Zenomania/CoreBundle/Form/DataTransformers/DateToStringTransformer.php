<?php

namespace Zenomania\CoreBundle\Form\DataTransformers;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class DateToStringTransformer implements DataTransformerInterface
{

    private $format;

    public function __construct($format)
    {
        $this->format = $format;
    }


    public function transform($value)
    {
        if (null === $value) {
            return '';
        } elseif ($value instanceof \DateTime) {
            return $value->format($this->format);
        } else {
            throw new TransformationFailedException();
        }
    }

    public function reverseTransform($value)
    {
        $result = \DateTime::createFromFormat($this->format, $value);
        if (false === $result) {
            throw new TransformationFailedException();
        } else {
            return $result;
        }
    }
}
