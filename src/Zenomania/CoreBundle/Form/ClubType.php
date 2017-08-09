<?php

namespace Zenomania\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClubType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('site')
            ->add('vkGroup')
            ->add('fbGroup')
            ->add('twitterGroup')
            ->add('instagramGroup')
            ->add('youtubeGroup')
            ->add('ytUploadPlaylist')
            ->add('sport')
            ->add('logoImg', FileType::class, ['required' => false, 'data_class' => null, 'label' => 'Логотип'])
            ->add('indexEnabled', null, ['label' => 'Индексировать']);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zenomania\CoreBundle\Entity\Club'
        ));
    }


}
