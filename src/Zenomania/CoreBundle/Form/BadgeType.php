<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 29.09.17
 * Time: 15:25
 */

namespace Zenomania\CoreBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Zenomania\CoreBundle\Form\Type\Calendar;

class BadgeType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Наименование'])
            ->add('code', TextType::class, ['label' => 'Код'])
            ->add('typeId', EntityType::class, [
                'class' => 'Zenomania\CoreBundle\Entity\BadgeType',
                'choice_label' => 'title',
                'label' => 'Вид бейджа'
            ])
            ->add('photo', FileType::class, ['required' => false, 'data_class' => null, 'label' => 'Стандартное фото'])
            ->add('photoBadge', FileType::class, ['required' => false, 'data_class' => null, 'label' => 'Фото бейджа'])
            ->add('sort', IntegerType::class, ['label' => 'Сортировка'])
            ->add('points', IntegerType::class, ['label' => 'Зены'])
            ->add('maxPoints', IntegerType::class, ['label' => 'Максимум зенов'])
            ->add('date', Calendar::class, [
                'type' => Calendar::DATE_TIME,
                'format' => 'dd.MM.yyyy HH:mm:ss',
                'description' => 'Дата начала мероприятия',
            ])
            ->add('active', CheckboxType::class, ['label' => 'Активен', 'required' => false]);

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zenomania\CoreBundle\Entity\Badge'
        ));
    }
}