<?php

namespace Zenomania\CoreBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Zenomania\CoreBundle\Entity\TicketForZen;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class TicketForZenType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')
            ->add('barcode', FileType::class, ['required' => false, 'data_class' => null, 'label' => 'Билет'])
            ->add('price')
            ->add('status', ChoiceType::class, [
                'choices'  => [
                    'Использован' => TicketForZen::TYPE_USED,
                    'Не использован' => TicketForZen::TYPE_NOT_USED,
                    'Куплен' => TicketForZen::TYPE_PURCHASED,
                ],
            ])
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
