<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 20.11.17
 * Time: 15:12
 */

namespace Zenomania\ApiBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderCartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('productId', IntegerType::class, ['required' => true]);
        $builder->add('quantity', IntegerType::class, ['required' => true]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Zenomania\ApiBundle\Form\Model\OrderCart'
        ]);
    }
}