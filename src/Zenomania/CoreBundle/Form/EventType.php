<?php

namespace Zenomania\CoreBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;
use Zenomania\CoreBundle\Form\DataTransformers\LineUpTransformer;
use Zenomania\CoreBundle\Form\DataTransformers\ScoreInRoundTransformer;
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
                'format' => 'dd.MM.yyyy HH:mm:ss',
                'description' => 'Дата начала мероприятия',
            ])
            ->add('purchasable', null, ['label' => 'Покупка билета ч/з программу лояльности'])
            ->add('chship')
            ->add('scoreHome', IntegerType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 3
                ],
                'required' => false
            ])
            ->add('scoreGuest', IntegerType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 3
                ],
                'required' => false
            ])
            ->add('scoreSaved', IntegerType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 1
                ],
                'required' => false
            ])
            ->add('isLineUp', null, ['label' => 'Опубликован состав', 'required' => false])
            ->add('clubHome', EntityType::class, [
                'class' => 'Zenomania\CoreBundle\Entity\Club',
                'choice_label' => 'name',
                'required' => true
            ])
            ->add('clubGuest', EntityType::class, [
                'class' => 'Zenomania\CoreBundle\Entity\Club',
                'choice_label' => 'name',
                'required' => true
            ])
            ->add('place', EntityType::class, [
                'class' => 'Zenomania\CoreBundle\Entity\Place',
                'choice_label' => 'name',
                'empty_data' => null,
                'placeholder' => 'Выберите место',
                'required' => false
            ])
            ->add('season', EntityType::class, [
                'class' => 'Zenomania\CoreBundle\Entity\Season',
                'choice_label' => 'name',
                'empty_data' => null,
                'placeholder' => 'Выберите сезон',
                'required' => false
            ])
            ->add('sport', EntityType::class, [
                'class' => 'Zenomania\CoreBundle\Entity\Sport',
                'choice_label' => 'name',
                'empty_data' => null,
                'placeholder' => 'Выберите вид спорта',
                'required' => false
            ])
            ->add('mvp', EntityType::class, [
                'class' => 'Zenomania\CoreBundle\Entity\Player',
                'choice_label' => 'lastname',
                'empty_data' => null,
                'placeholder' => 'Выберите игрока',
                'required' => false
            ])
            ->add('scoreInRounds', null, ['label' => 'Счёт по партиям', 'required' => false])
            ->add('rounds', CollectionType::class, [
                'entry_type' => ScoreInRoundType::class,
                'entry_options' => array('label' => false),
            ])
            ->add('lineup', CollectionType::class, [
                'entry_type' => LineUpType::class,
                'entry_options' => array('label' => false),
            ]);

        $builder
            ->addModelTransformer(new LineUpTransformer());
        $builder
            ->addModelTransformer(new ScoreInRoundTransformer());
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
