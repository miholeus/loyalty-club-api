<?php

namespace Zenomania\CoreBundle\Form\DataTransformers;


use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Zenomania\CoreBundle\Service\User;


class EmailToUserTransformer implements DataTransformerInterface
{

    private $userService;

    public function __construct(User $userService)
    {
        $this->userService = $userService;
    }


    public function transform($value)
    {
        if(null === $value) {
            return '';
        } else if($value instanceof \Zenomania\CoreBundle\Entity\User) {
            return $value->getEmail();
        } else {
            throw new TransformationFailedException();
        }
    }

    public function reverseTransform($value)
    {
        return $this->userService->findByEmail($value);
    }

}