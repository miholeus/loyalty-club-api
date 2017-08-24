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
        $builder->add('cardcode', TextType::class);
        $builder->add('sector', TextType::class);
        $builder->add('row', TextType::class);
        $builder->add('seat', TextType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zenomania\CoreBundle\Entity\Subscription'
        ));
    }

    public function getBlockPrefix()
    {
        return 'zenomania_core_bundle_subscription_number';
    }
}
