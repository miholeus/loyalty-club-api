<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 14.09.17
 * Time: 14:59
 */

namespace Zenomania\ApiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\DateTime;


class UserProfileType extends AbstractType
{
    /**
    * {@inheritdoc}
    */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('first_name', TextType::class, ['required' => false]);
        $builder->add('last_name', IntegerType::class, ['required' => true]);
        $builder->add('middle_name', TextType::class, ['required' => false]);
        $builder->add('phone', IntegerType::class, ['required' => true]);
        $builder->add('email', IntegerType::class, ['required' => true]);
        $builder->add('city', IntegerType::class, ['required' => false]);
        $builder->add('country', IntegerType::class, ['required' => false]);
        $builder->add('birthday', DateTimeType::class, ['required' => false]);
    }
}