<?php

namespace Zenomania\CoreBundle\Form\DataTransformers;

use Doctrine\Common\Collections\Collection;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * Class AbstractIdToEntityTransformer
 * @package Zenomania\CoreBundle\Form\DataTransformers
 */
abstract class AbstractIdToEntityTransformer implements DataTransformerInterface
{
    /**
     * @param mixed $value
     * @return string
     */
    public function transform($value)
    {
        if (null === $value) {
            return '';
        } else if ($value instanceof Collection) {
            return implode(',', $this->getIdArray($value));
        } else {
            throw new TransformationFailedException();
        }
    }

    /**
     * @param mixed $value
     * @return object[]
     */
    public function reverseTransform($value)
    {
        if (!is_string($value)) {
            throw new TransformationFailedException();
        }
        $ids = explode(',', $value);
        foreach ($ids as $id) {
            if (!is_numeric($id)) {
                throw new TransformationFailedException();
            }
        }
        if (null === $value || !$ids || empty($ids)) {
            throw new TransformationFailedException();
        }
        $entities = $this->getEntitiesByIds($ids);
        // if requested values contain not existing data
        if (count($ids) > count($entities)) {
            throw new TransformationFailedException();
        }
        return $entities;
    }

    /**
     * @param Collection $collection
     * @return array
     */
    abstract protected function getIdArray(Collection $collection);

    /**
     * @param array $ids
     * @return object[]
     */
    abstract protected function getEntitiesByIds(array $ids);
}
