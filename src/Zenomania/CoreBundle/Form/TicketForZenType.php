<?php

namespace Zenomania\CoreBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketForZenType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')
            ->add('barcode')
            ->add('price')
            ->add('status')
            ->add('event', EntityType::class, [
                'class' => 'Zenomania\CoreBundle\Entity\Event',
                'choice_label' => 'name',
                'empty_data' => null,
                'placeholder' => 'Выберите мероприятие',
                'required' => false
            ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zenomania\CoreBundle\Entity\TicketForZen'
        ));
    }

}
