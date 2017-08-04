<?php
/**
 * @package    Zenomania\CoreBundle\Form
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */

namespace Zenomania\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Zenomania\CoreBundle\Form\Constraints\UserConstraint;
use Zenomania\CoreBundle\Form\DataTransformers\EmailToUserTransformer;
use Zenomania\CoreBundle\Service\User;

class UserByEmailType extends AbstractType
{
    private $userService;

    public function __construct(User $userService)
    {
        $this->userService = $userService;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', EmailType::class, [
                'constraints' => [
                    new UserConstraint("Пользователь с таким email не существует")
                ],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Email',
                    'autofocus' => true,
                    'required' => true
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Отправить код',
                'attr' => [
                    'class' => 'btn btn-primary btn-block btn-flat',
                ]
            ]);
        $builder->get('user')
            ->addModelTransformer(new EmailToUserTransformer($this->userService));
    }
}
