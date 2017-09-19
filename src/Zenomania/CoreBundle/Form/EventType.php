<?php

namespace Zenomania\CoreBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;
use Zenomania\CoreBundle\Entity\Player;
use Zenomania\CoreBundle\Form\Type\Calendar;

class EventType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('date', Calendar::class, [
                'type' => Calendar::DATE_TIME,
                'required' => true,
                'description' => 'Дата начала мероприятия',
            ])
            ->add('purchasable', null, ['label' => 'Покупка билета ч/з программу лояльности'])
            ->add('chship')
            ->add('scoreHome', IntegerType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 3
                ]
            ])
            ->add('scoreGuest', IntegerType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 3
                ]
            ])
            ->add('scoreSaved', IntegerType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 1
                ]
            ])
            ->add('isLineUp', null, ['label' => 'Опубликован состав'])
            ->add('scoreInRounds')
            ->add('clubHome')
            ->add('clubGuest')
            ->add('place', EntityType::class, [
                'class' => 'Zenomania\CoreBundle\Entity\Place',
                'choice_label' => 'name',
                'empty_data' => null
            ])
            ->add('promoAction', EntityType::class, [
                'class' => 'Zenomania\CoreBundle\Entity\PromoAction',
                'choice_label' => 'name'
            ])
            ->add('sport', EntityType::class, [
                'class' => 'Zenomania\CoreBundle\Entity\Sport',
                'choice_label' => 'name'
            ])
            ->add('mvp', EntityType::class, [
                'class' => 'Zenomania\CoreBundle\Entity\Player',
                'choice_label' => 'lastname'
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
