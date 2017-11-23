<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 20.11.17
 * Time: 14:25
 */

namespace Zenomania\ApiBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Zenomania\ApiBundle\Form\Model\OrderDelivery;

class OrderType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('note', TextType::class, ['required' => false]);
        $builder->add('orderCart', CollectionType::class, [
            'entry_type' => OrderCartType::class,
            'entry_options' => [],
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
        ]);

        $builder->add($builder->create('orderDelivery', FormType::class, [
            'data_class' => OrderDelivery::class
        ])
            ->add('phone', TextType::class, ['required' => true])
            ->add('clientName', TextType::class, ['required' => false])
            ->add('address', TextType::class, ['required' => false])
            ->add('note', TextType::class, ['required' => false])
            ->add('deliveryTypeId', IntegerType::class, ['required' => false])
        );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zenomania\ApiBundle\Form\Model\Order'
        ));
    }
}