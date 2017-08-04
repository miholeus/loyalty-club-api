<?php

namespace Zenomania\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Zenomania\CoreBundle\Form\Model\Search;

class SearchType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('query', TextType::class, [
            'required' => true,
            'label' => false,
            'attr' => [
                'placeholder' => $options['query_placeholder']
            ]
        ])
            ->add('clear', SubmitType::class, [
                'label' => 'Сброс'
            ])
            ->add('search', SubmitType::class, [
                'label' => 'Поиск'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            'query_placeholder' => 'строка поиска'
        ]);
    }

}