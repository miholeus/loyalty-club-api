<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 25.09.17
 * Time: 19:06
 */

namespace Zenomania\ApiBundle\Form\DataTransformers;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class TypeToDatePeriod implements DataTransformerInterface
{

    public function transform($value)
    {

    }

    public function reverseTransform($value)
    {
        if (null === $value) {
            return $value;
        } else if (in_array($value, ['month', 'season'])) {
                $today = new \DateTime();
                $winter = new \DateTime('December 1');
                $spring = new \DateTime('March 1');
                $summer = new \DateTime('June 1');
                $fall = new \DateTime('September 1');
                switch ($value) {
                    case 'season':
                        switch ($today) {
                            case $today >= $winter && $today < $spring:
                                return $winter->format('Y-m-d');
                            case $today >= $spring && $today < $summer:
                                return $spring->format('Y-m-d');
                            case $today >= $summer && $today < $fall:
                                return $summer->format('Y-m-d');
                            case $today >= $fall && $today < $winter:
                                return $fall->format('Y-m-d');

                        }
                    case 'month':
                        $today = new \DateTime('first day of this month');
                        return $today->format('Y-m-d');
                }
            } else {
                throw new TransformationFailedException();
            }
        }
}