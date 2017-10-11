<?php

namespace Zenomania\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Zenomania\CoreBundle\Entity\PersonPoints;

class PointsTypeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class, [
                'choices'  => [
                    'Посещение по билету' => PersonPoints::TYPE_TICKET_REGISTER,
                    'Посещение по абонементу' => PersonPoints::TYPE_SUBSCRIPTION_REGISTER,
                ],
            ])
            ->add('interval', IntegerType::class, [
                'attr' => [
                    'min' => -120,
                    'max' => 120
                ]
            ])
            ->add('percent', IntegerType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 100
                ]
            ])
            ->add('isActive');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zenomania\CoreBundle\Entity\PointsType'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'zenomania_corebundle_pointstype';
    }


}
