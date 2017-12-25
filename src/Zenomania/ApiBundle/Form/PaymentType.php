<?php
/**
 * Created by PhpStorm.
 * User: igorvolkov
 * Date: 26.12.2017
 * Time: 1:19
 */

namespace Zenomania\ApiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaymentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('amount', MoneyType::class, ['required' => true]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Zenomania\ApiBundle\Form\Model\Payment'
        ]);
    }
}