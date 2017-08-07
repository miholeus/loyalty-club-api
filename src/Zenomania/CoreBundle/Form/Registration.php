<?php
/**
 * @package    Zenomania\CoreBundle\Form
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */

namespace Zenomania\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Gregwar\CaptchaBundle\Type\CaptchaType;

/**
 * Register new users
 */
class Registration extends AbstractType
{
    /**
     * @var array
     */
    protected $options;

    public function __construct(array $options = array())
    {
        $this->options = $options;
    }

    /**
     * Get option
     *
     * @param $name
     * @return null
     */
    protected function getOption($name)
    {
        return isset($this->options[$name]) ? $this->options[$name] : null;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        switch ($options['flow_step']) {
            case 1:
                $this->addPhoneField($builder)
                    ->add('captcha', CaptchaType::class, [
                        'attr' => [
                            'class' => 'form-control',
                            'placeholder' => 'Текст с картинки'
                        ]
                    ])
                    ->add('reset', ResetType::class, [
                        'label' => 'Отмена',
                        'attr' => [
                            'class' => 'btn btn-primary btn-flat',
                        ]
                    ])
                    ->add('submit', SubmitType::class, [
                        'label' => 'Продолжить',
                        'attr' => [
                            'class' => 'btn btn-primary btn-flat',
                        ]
                    ]);
                break;
            case 2:
                $this->addPhoneField($builder)
                    ->add('sms_code', TextType::class, [
                        'attr' => [
                            'class' => 'form-control'
                        ]
                    ])
                    ->add('token', HiddenType::class)
                    ->add('reset', ResetType::class, [
                        'label' => 'Отмена',
                        'attr' => [
                            'class' => 'btn btn-primary btn-flat',
                        ]
                    ])
                    ->add('submit', SubmitType::class, [
                        'label' => 'Продолжить',
                        'attr' => [
                            'class' => 'btn btn-primary btn-flat',
                        ]
                    ]);
                break;

            case 3:
                $builder->add('first_name', TextType::class, [
                    'property_path' => 'firstName',
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ])
                    ->add('last_name', TextType::class, [
                        'property_path' => 'lastName',
                        'attr' => [
                            'class' => 'form-control'
                        ]
                    ])
                    ->add('middle_name', TextType::class, [
                        'property_path' => 'middleName',
                        'attr' => [
                            'class' => 'form-control'
                        ]
                    ])
                    ->add('login', TextType::class, [
                        'attr' => [
                            'class' => 'form-control'
                        ]
                    ])
                    ->add('reset', ResetType::class, [
                        'label' => 'Отмена',
                        'attr' => [
                            'class' => 'btn btn-primary btn-flat',
                        ]
                    ])
                    ->add('submit', SubmitType::class, [
                        'label' => 'Сохранить',
                        'attr' => [
                            'class' => 'btn btn-primary btn-flat',
                        ]
                    ])->add('token', HiddenType::class);
                if (!$this->getOption('password_text')) {
                    $builder->add('password', RepeatedType::class, [
                        'type' => PasswordType::class,
                        'invalid_message' => 'Пароли не совпадают',
                        'options' => [
                            'attr' => [
                                'class' => 'form-control'
                            ]
                        ],
                        'required' => true,
                        'first_options' => ['label' => 'Пароль'],
                        'second_options' => ['label' => 'Повторите пароль']
                    ]);
                } else {
                    $builder->add('password');
                }
                break;
        }
    }

    protected function addPhoneField(FormBuilderInterface $builder)
    {
        $builder
            ->add('phone', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Телефон',
                    'autofocus' => true
                ]
            ]);

        $builder->get('phone')
            ->addModelTransformer(new CallbackTransformer(
                function ($value) {
                    if (!empty($value)) {
                        return "+" . preg_replace("/[^0-9]+/", "", $value);
                    }
                    return $value;
                },
                function ($value) {
                    return preg_replace("/[^0-9]+/", "", $value);
                }
            ));

        return $builder;
    }

    public function getBlockPrefix()
    {
        return 'registration';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zenomania\CoreBundle\Form\Model\Registration',
            'password_text' => null
        ));
    }
}