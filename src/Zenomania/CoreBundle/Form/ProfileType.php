<?php

namespace Zenomania\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ProfileType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, ['attr' => [
                'class' => 'form-control'
            ], 'label' => 'Имя'])
            ->add('lastname', TextType::class, ['attr' => [
                'class' => 'form-control'
            ], 'label' => 'Фамилия'])
            ->add('middlename', TextType::class, ['attr' => [
                'class' => 'form-control'
            ], 'label' => 'Отчество'])
            ->add('login', TextType::class, ['attr' => [
                'class' => 'form-control'
            ], 'label' => 'Логин'])
            ->add('email', EmailType::class, ['attr' => [
                'class' => 'form-control'
            ], 'label' => 'Email'])
            ->add('password', PasswordType::class, ['attr' => [
                'class' => 'form-control'
            ], 'label' => 'Пароль'])
            ->add('birthDate', DateType::class, ['attr' => [
                'class' => 'form-control'
            ], 'label' => 'Дата рождения'])
            ->add('avatar')
            ->add('phone', TextType::class, ['attr' => [
                'class' => 'form-control',
                'data-inputmask' => '"mask": "(999) 999-9999"',
            ], 'label' => 'Телефон основной']);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zenomania\CoreBundle\Entity\User'
        ));
    }
}
