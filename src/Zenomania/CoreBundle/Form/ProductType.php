<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 31.10.17
 * Time: 18:48
 */

namespace Zenomania\CoreBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProductType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categoryId', EntityType::class, [
                'class' => 'Zenomania\CoreBundle\Entity\ProductCategory',
                'choice_label' => 'title',
                'label' => 'Category'
            ])
            ->add('title', TextType::class, ['label' => 'Title'])
            ->add('description', TextType::class, ['label' => 'Description'])
            ->add('photo', FileType::class, ['required' => false, 'data_class' => null, 'label' => 'Фото'])
            ->add('price', MoneyType::class, ['label' => 'Price'])
            ->add('quantity', IntegerType::class, ['label' => 'Quantity'])
            ->add('position', IntegerType::class, ['label' => 'Position'])
            ->add('published', CheckboxType::class, ['label' => 'Published', 'required' => false]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zenomania\CoreBundle\Entity\Product'
        ));
    }
}