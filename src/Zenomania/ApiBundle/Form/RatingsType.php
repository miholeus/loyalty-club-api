<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 25.09.17
 * Time: 15:57
 */

namespace Zenomania\ApiBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Zenomania\ApiBundle\Form\DataTransformers\TypeToDatePeriod;


class RatingsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('limit', IntegerType::class, ['required' => false]);
        $builder->add('offset', IntegerType::class, ['required' => false]);
        $builder->add('period', TextType::class, ['required' => false]);
        $builder->get('period')->addModelTransformer(new TypeToDatePeriod());
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zenomania\ApiBundle\Form\Model\Ratings',
        ));
    }
}