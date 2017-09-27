<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 27.09.17
 * Time: 19:12
 */

namespace Zenomania\ApiBundle\Form\DataTransformers;

use Symfony\Component\Form\DataTransformerInterface;
use Zenomania\CoreBundle\Repository\BadgeTypeRepository;

class IdToBadgeType implements DataTransformerInterface
{
    /**
     * @var BadgeTypeRepository
     */
    private $badgeTypeRepository;

    public function __construct(BadgeTypeRepository $badgeTypeRepository)
    {
        $this->badgeTypeRepository = $badgeTypeRepository;
    }

    public function transform($value)
    {

    }

    public function reverseTransform($value)
    {
        if (null === $value) {
            return '';
        } else if (is_numeric($value)) {
            $badgeType = $this->getBadgeTypeRepository()->find($value);
            return $badgeType;
        } else {
            throw new TransformationFailedException();
        }
    }

    /**
     * @return BadgeTypeRepository
     */
    public function getBadgeTypeRepository(): BadgeTypeRepository
    {
        return $this->badgeTypeRepository;
    }
}