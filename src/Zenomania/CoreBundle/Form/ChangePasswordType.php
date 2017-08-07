<?php
/**
 * @package    Zenomania\CoreBundle\Form
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */

namespace Zenomania\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code', HiddenType::class, [])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Пароли должны совпадать',
                'first_options'  => [
                    'attr' => [
                        'placeholder' => 'Новый пароль',
                        'class' => 'form-control'
                    ]
                ],
                'second_options' => [
                    'attr' => [
                        'placeholder' => 'Подтверждение пароля',
                        'class' => 'form-control'
                    ]
                ],
                'required' => true
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Сменить пароль',
                'attr' => [
                    'class' => 'btn btn-primary btn-block btn-flat',
                ]
            ]);
    }

}