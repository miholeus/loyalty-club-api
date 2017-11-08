<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 07.11.17
 * Time: 19:03
 */

namespace Zenomania\CoreBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DeliveryType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('deliveryTypeId', EntityType::class, [
            'class' => 'Zenomania\CoreBundle\Entity\DeliveryType',
            'choice_label' => 'title',
        ]);
        $builder->add('clientName', TextType::class);
        $builder->add('address', TextType::class);
        $builder->add('phone', IntegerType::class);
        $builder->add('note', TextType::class, ['required' => false]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zenomania\CoreBundle\Entity\OrderDelivery'
        ));
    }
}