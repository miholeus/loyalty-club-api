<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 15.09.17
 * Time: 17:00
 */

namespace Zenomania\ApiBundle\Form\DataTransformers;

use Zenomania\ApiBundle\Service\UserProfile;
use \Zenomania\CoreBundle\Entity\City;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Zenomania\CoreBundle\Repository\CityRepository;


class IdCityObjectTransformer implements DataTransformerInterface
{
    /**
     * @var CityRepository
     */
    protected $cityRepository;

    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    /**
     * @return CityRepository
     */
    public function getCityRepository(): CityRepository
    {
        return $this->cityRepository;
    }

    public function transform($value)
    {
        if (null === $value) {
            return '';
        } else if ($value instanceof \Zenomania\CoreBundle\Entity\City) {
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
            $city = $this->getCityRepository()->findCityById($value);
            return $city;
        } else {
            throw new TransformationFailedException();
        }
    }
}