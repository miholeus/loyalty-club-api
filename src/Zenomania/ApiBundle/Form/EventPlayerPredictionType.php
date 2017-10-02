<?php
/**
 * @package    Zenomania\ApiBundle\Form
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Zenomania\ApiBundle\Form\DataTransformers\IdToPlayerTransformer;

class EventPlayerPredictionType extends AbstractType
{
    /**
     * @var \Zenomania\CoreBundle\Service\Player
     */
    private $playerService;

    public function __construct(\Zenomania\CoreBundle\Service\Player $playerService)
    {
        $this->playerService = $playerService;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('players', TextType::class, ['description' => 'Список идентификаторов игроков']);

        $builder->add('mvp', EntityType::class, [
            'class' => 'Zenomania\CoreBundle\Entity\Player',
            'choice_label' => 'lastname'
        ]);

        $builder->get('players')->addModelTransformer(new IdToPlayerTransformer($this->getPlayerService()));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zenomania\ApiBundle\Form\Model\EventPlayerPrediction',
        ));
    }

    /**
     * @return \Zenomania\CoreBundle\Service\Player
     */
    public function getPlayerService(): \Zenomania\CoreBundle\Service\Player
    {
        return $this->playerService;
    }


}