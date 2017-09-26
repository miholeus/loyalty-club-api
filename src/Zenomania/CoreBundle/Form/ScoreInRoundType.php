<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 20.09.2017
 * Time: 13:09
 */

namespace Zenomania\CoreBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Zenomania\CoreBundle\Form\Model\ScoreInRound;

class ScoreInRoundType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nameRound', TextType::class, [
                'disabled' => true
            ])
            ->add('homeScore', IntegerType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 99
                ]
            ])
            ->add('guestScore', IntegerType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 99
                ]
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ScoreInRound::class,
        ));
    }
}