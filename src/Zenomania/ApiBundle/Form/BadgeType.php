<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 27.09.17
 * Time: 17:18
 */

namespace Zenomania\ApiBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Zenomania\ApiBundle\Form\DataTransformers\IdToBadgeType;
use Zenomania\CoreBundle\Repository\BadgeTypeRepository;

class BadgeType extends AbstractType
{
    private $badgeTypeRepository;

    public function __construct(BadgeTypeRepository $badgeTypeRepository)
    {
        $this->badgeTypeRepository = $badgeTypeRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class, ['required' => true]);
        $builder->add('code', TextType::class, ['required' => true]);
        $builder->add('photo', TextType::class, ['required' => true]);
        $builder->add('typeId', IntegerType::class, ['required' => true]);
        $builder->add('sort', IntegerType::class, ['required' => true]);
        $builder->add('points', IntegerType::class, ['required' => true]);
        $builder->add('maxPoints', IntegerType::class, ['required' => true]);
        $builder->add('active', CheckboxType::class, ['required' => true]);

        $builder->get('typeId')->addModelTransformer(new IdToBadgeType($this->getBadgeTypeRepository()));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zenomania\CoreBundle\Entity\Badge',
        ));
    }

    /**
     * @return BadgeTypeRepository
     */
    public function getBadgeTypeRepository(): BadgeTypeRepository
    {
        return $this->badgeTypeRepository;
    }
}