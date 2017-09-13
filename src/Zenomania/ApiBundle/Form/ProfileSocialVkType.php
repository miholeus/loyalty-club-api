<?php

namespace Zenomania\ApiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileSocialVkType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('accessToken', TextType::class, ['required' => true]);
        $builder->add('userId', IntegerType::class, ['required' => true]);
        $builder->add('email', TextType::class, ['required' => true]);
        $builder->add('expiresIn', IntegerType::class, ['required' => true]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
    /*    $resolver->setDefaults(array(
            'data_class' => 'Zenomania\ApiBundle\Form\Model\ProfileSocialData',
        ));*/
    }
}
