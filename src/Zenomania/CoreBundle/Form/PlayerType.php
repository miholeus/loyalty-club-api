<?php

namespace Zenomania\CoreBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Zenomania\CoreBundle\Form\Type\Calendar;

class PlayerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', null, ['label' => 'Имя'])
            ->add('lastname', null, ['label' => 'Фамилия'])
            ->add('middlename', null, ['label' => 'Отчество'])
            ->add('bdate', Calendar::class, [
                'type' => Calendar::DAY,
                'label' => 'Дата рождения',
                'required' => false,
            ])
            ->add('foto', FileType::class, ['required' => false, 'data_class' => null, 'label' => 'Фото'])
            ->add('isActive', null, ['label' => 'Активен'])
            ->add('createdOn')
            ->add('updatedOn')
            ->add('club', EntityType::class, [
                'class' => 'Zenomania\CoreBundle\Entity\Club',
                'choice_label' => 'name',
            ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zenomania\CoreBundle\Entity\Player'
        ));
    }


}
