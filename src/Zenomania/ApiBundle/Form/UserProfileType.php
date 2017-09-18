<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 14.09.17
 * Time: 14:59
 */

namespace Zenomania\ApiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Zenomania\ApiBundle\Form\DataTransformers\IdCityObjectTransformer;
use Zenomania\ApiBundle\Form\DataTransformers\IdToDistrictObjectTransformer;
use Zenomania\CoreBundle\Repository\CityRepository;
use Zenomania\CoreBundle\Repository\DistrictRepository;

class UserProfileType extends AbstractType
{

    protected $cityRepository;

    protected $districtRepository;

    public function __construct(CityRepository $cityRepository, DistrictRepository $districtRepository)
    {
        $this->cityRepository = $cityRepository;
        $this->districtRepository = $districtRepository;
    }

    /**
     * @return CityRepository
     */
    public function getCityRepository(): CityRepository
    {
        return $this->cityRepository;
    }

    /**
     * @return DistrictRepository
     */
    public function getDistrictRepository(): DistrictRepository
    {
        return $this->districtRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstName', TextType::class, ['required' => false]);
        $builder->add('lastName', TextType::class, ['required' => true]);
        $builder->add('middleName', TextType::class, ['required' => false]);
        $builder->add('phone', TextType::class, ['required' => true]);
        $builder->add('email', TextType::class, ['required' => true]);
        $builder->add('city', TextType::class, ['required' => false]);
        $builder->add('district', TextType::class, ['required' => false]);
        $builder->add('birthDate', TextType::class, ['required' => false]);

        $builder->get('city')->addModelTransformer(new IdCityObjectTransformer($this->getCityRepository()));
        $builder->get('district')->addModelTransformer(new IdToDistrictObjectTransformer($this->getDistrictRepository()));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zenomania\ApiBundle\Form\Model\UserProfile',
        ));
    }
}