<?php

namespace Zenomania\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Zenomania\CoreBundle\Entity\UserStatus;

class UserStatusType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('code', ChoiceType::class, [
                'choices' => [
                    UserStatus::STATUS_ACTIVE => 'Активен',
                    UserStatus::STATUS_BLOCKED => 'Заблокирован',
                    UserStatus::STATUS_DELETED => 'Удален',
                    UserStatus::STATUS_REGISTERED => 'Зарегистрирован'
                ]
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zenomania\CoreBundle\Entity\UserStatus'
        ));
    }
}
