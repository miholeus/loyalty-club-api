<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 14.09.17
 * Time: 14:59
 */

namespace Zenomania\ApiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Zenomania\ApiBundle\Form\DataTransformers\IdCityObjectTransformer;
use Zenomania\ApiBundle\Form\DataTransformers\IdToDistrictObjectTransformer;

class UserProfileType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstName', TextType::class, ['required' => false]);
        $builder->add('lastName', TextType::class, ['required' => true]);
        $builder->add('middleName', TextType::class, ['required' => false]);
        $builder->add('phone', TextType::class, ['required' => true]);
        $builder->add('email', TextType::class, ['required' => true]);
        $builder->add('city', TextType::class, ['required' => false]);
        $builder->add('district', TextType::class, ['required' => false]);
        $builder->add('birthDate', TextType::class, ['required' => false]);

        $builder->get('city')->addModelTransformer(new IdCityObjectTransformer());
        $builder->get('district')->addModelTransformer(new IdToDistrictObjectTransformer());
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zenomania\ApiBundle\Form\Model\UserProfile',
        ));
    }
}