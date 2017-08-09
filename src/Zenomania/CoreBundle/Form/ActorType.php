<?php

namespace Zenomania\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActorType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('password')
            ->add('token')
            ->add('refrr')
            ->add('shouldChangePwd')
            ->add('authToken')
            ->add('vkId')
            ->add('fbId')
            ->add('resetToken')
            ->add('regDate')
            ->add('regSource')
            ->add('clubOwner')
            ->add('person')->add('roles');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zenomania\CoreBundle\Entity\Actor'
        ));
    }


}
