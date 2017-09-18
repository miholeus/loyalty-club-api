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
use Zenomania\CoreBundle\Repository\DistrictRepository;

class IdToDistrictObjectTransformer implements DataTransformerInterface
{
    /**
     * @var DistrictRepository
     */
    protected $districtRepository;

    public function __construct(DistrictRepository $districtRepository)
    {
        $this->districtRepository = $districtRepository;
    }

    /**
     * @return DistrictRepository
     */
    public function getDistrictRepository(): DistrictRepository
    {
        return $this->districtRepository;
    }

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
            $district = $this->getDistrictRepository()->findDistrictById($value);
            return $district;
        } else {
            throw new TransformationFailedException();
        }
    }

}