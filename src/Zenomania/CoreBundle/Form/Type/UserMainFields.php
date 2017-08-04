<?php
/**
 * @package    Zenomania\CoreBundle\Form\Type
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */

namespace Zenomania\CoreBundle\Form\Type;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Main user form that is used to save general user fields
 */
class UserMainFields extends Profile
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('login', null, ['label' => 'Логин'])
            ->add('password', PasswordType::class, ['required' => false, 'label' => 'Пароль'])
            ->add('phone', null, ['label' => 'Телефон'])
            ->add('status', EntityType::class, [
                'class' => 'Zenomania\CoreBundle\Entity\UserStatus',
                'choice_label' => 'name',
            ])
            ->add('role', EntityType::class, [
                'class' => 'Zenomania\CoreBundle\Entity\UserRole',
                'choice_label' => 'name',
            ]);
    }
}
