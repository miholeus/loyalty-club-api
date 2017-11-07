<?php

namespace Zenomania\CoreBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class OrderType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('statusId', EntityType::class, [
            'class' => 'Zenomania\CoreBundle\Entity\OrderStatus',
            'choice_label' => 'title',
        ]);
        $builder->add('userId', EntityType::class, [
            'class' => 'Zenomania\CoreBundle\Entity\User',
            'choice_label' => function ($value) {
                return $value->getFirstname() . ' ' . $value->getLastname() . ' ' . $value->getMiddlename();
            },
        ]);
        $builder->add('deliveryTypeId', EntityType::class, [
            'class' => 'Zenomania\CoreBundle\Entity\DeliveryType',
            'choice_label' => 'title',
        ]);
        $builder->add('deliveryTypeId', EntityType::class, [
            'class' => 'Zenomania\CoreBundle\Entity\DeliveryType',
            'choice_label' => 'title',
        ]);
        $builder->add('productId', EntityType::class, [
            'class' => 'Zenomania\CoreBundle\Entity\Product',
            'choice_label' => 'title',
        ]);
        $builder->add('quantity', IntegerType::class);
        $builder->add('price', MoneyType::class);
        $builder->add('totalPrice', MoneyType::class);
        $builder->add('note', TextType::class, ['required' => false]);
        $builder->add('date', DateTimeType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zenomania\CoreBundle\Form\Model\Order'
        ));
    }


}
