<?php

namespace Zenomania\CoreBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('date')
            ->add('purchasable', null, ['label' => 'Есть'])
            ->add('chship')
            ->add('scoreHome')
            ->add('scoreGuest')
            ->add('scoreSaved')
            ->add('isLineUp', null, ['label' => 'Опубликован состав'])
            ->add('scoreInRounds')
            ->add('clubHome')
            ->add('clubGuest')
            ->add('place')
            ->add('promoAction', EntityType::class, [
                'class' => 'Zenomania\CoreBundle\Entity\PromoAction',
                'choice_label' => 'name',
            ])
            ->add('sport', EntityType::class, [
                'class' => 'Zenomania\CoreBundle\Entity\Sport',
                'choice_label' => 'name',
            ])
            ->add('mvp', EntityType::class, [
                'class' => 'Zenomania\CoreBundle\Entity\Player',
                'choice_label' => 'lastname',
            ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zenomania\CoreBundle\Entity\Event'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'zenomania_corebundle_event';
    }


}
