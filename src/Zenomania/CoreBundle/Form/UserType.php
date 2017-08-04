<?php

namespace Zenomania\CoreBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Zenomania\CoreBundle\Form\Type\UserMainFields;
use Symfony\Component\Form\Extension\Core\Type\FileType;

/**
 * All user fields live here
 */
class UserType extends UserMainFields
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('isActive', null, ['label' => 'Активен'])
            ->add('isSuperuser', null, ['label' => 'Суперпользователь'])
            ->add('avatar', FileType::class, ['required' => false, 'data_class' => null, 'label' => 'Фото']);
    }
}
