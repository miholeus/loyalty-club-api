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
                    'Активен' => UserStatus::STATUS_ACTIVE,
                    'Заблокирован' => UserStatus::STATUS_BLOCKED,
                    'Удален' => UserStatus::STATUS_DELETED,
                    'Зарегистрирован' => UserStatus::STATUS_REGISTERED
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
