<?php

namespace Zenomania\CoreBundle\Form;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Zenomania\CoreBundle\Entity\ScoreInRound;

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
            ->add('clubHome')
            ->add('clubGuest')
            ->add('place', EntityType::class, [
                'class' => 'Zenomania\CoreBundle\Entity\Place',
                'choice_label' => 'name'
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
            ])
            ->add('scoreInRounds', CollectionType::class, [
                'entry_type' => ScoreInRoundType::class,
                'entry_options' => array('label' => false),
            ]);

        $builder->get('scoreInRounds')
            ->addModelTransformer(new CallbackTransformer(
                function ($a) {
                    return $a;
                },
                function ($rounds) {
                    $array = [];
                    /** @var ScoreInRound $round */
                    foreach ($rounds as $round) {
                        if (($round->getHomeScore() <= 15) && ($round->getGuestScore() <= 15)) {
                            break;
                        }
                        $array[] = $round->getHomeScore() . ":" . $round->getGuestScore();
                    }

                    return implode(', ', $array);
                }
            ));
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
