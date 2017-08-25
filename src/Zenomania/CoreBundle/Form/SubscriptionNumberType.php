<?php

namespace Zenomania\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubscriptionNumberType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('cardcode', TextType::class, ['required' => true]);
        $builder->add('sector', TextType::class, ['required' => true]);
        $builder->add('row', TextType::class, ['required' => true]);
        $builder->add('seat', TextType::class, ['required' => true]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        /*$resolver->setDefaults(array(
            'data_class' => 'Zenomania\CoreBundle\Entity\SubscriptionNumber'
        ));*/
    }

    public function getBlockPrefix()
    {
        /*return 'zenomania_core_bundle_subscription_number';*/
    }
}
