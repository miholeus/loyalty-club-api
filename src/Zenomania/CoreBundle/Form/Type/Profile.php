<?php
/**
 * @package    Zenomania\CoreBundle\Form\Type
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */

namespace Zenomania\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Profile extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('login', null, ['label' => 'Уникальное имя пользователя'])
            ->add('firstname', null, ['label' => 'Имя'])
            ->add('lastname', null, ['label' => 'Фамилия'])
            ->add('middlename', null, ['label' => 'Отчество'])
            ->add('email', null, ['label' => 'Email'])
            ->add('birthDate', Calendar::class, [
                'type' => Calendar::DAY,
                'label' => 'Дата рождения',
                'required' => false,
            ]);
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

    public function getName()
    {
        return 'user';
    }
}
