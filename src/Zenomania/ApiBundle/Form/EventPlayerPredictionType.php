<?php
/**
 * @package    Zenomania\ApiBundle\Form
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Zenomania\ApiBundle\Form\DataTransformers\IdToPlayerTransformer;
use Zenomania\CoreBundle\Entity\EventPlayerForecast;

class EventPlayerPredictionType extends AbstractType
{
    /**
     * @var \Zenomania\CoreBundle\Service\Player
     */
    private $playerService;
    /**
     * @var TokenStorage
     */
    private $tokenStorage;
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $forecasts;

    public function __construct(\Zenomania\CoreBundle\Service\Player $playerService, TokenStorage $tokenStorage)
    {
        $this->playerService = $playerService;
        $this->tokenStorage = $tokenStorage;
        $this->forecasts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Adds forecast
     *
     * @param EventPlayerForecast $forecast
     */
    protected function addForecast(EventPlayerForecast $forecast)
    {
        $this->forecasts[] = $forecast;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('players', TextType::class, ['description' => 'Список идентификаторов игроков']);

        $builder->add('mvp', EntityType::class, [
            'class' => 'Zenomania\CoreBundle\Entity\Player',
            'choice_label' => 'lastname'
        ]);

        $builder->add('event', EntityType::class, [
            'class' => 'Zenomania\CoreBundle\Entity\Event',
            'choice_label' => 'name'
        ]);

        $builder->get('players')->addModelTransformer(new IdToPlayerTransformer($this->getPlayerService()));

        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $e) {
            $form = $e->getForm();
            /** @var \Zenomania\ApiBundle\Form\Model\EventPlayerPrediction $data */
            $data = $e->getData();

            $players = $data->getPlayers();

            $event = $form->get('event')->getData();
            /** @var \Zenomania\CoreBundle\Entity\Player $player */
            foreach ($players as $player) {
                $forecast = $this->createForecast($player, $event);
                $this->addForecast($forecast);
            }

            $mvp = $data->getMvp();
            $this->addForecast($this->createForecast($mvp, $event, true));

            $data->setForecasts($this->getForecasts());
        });
    }

    /**
     * Creates new player forecast instance
     *
     * @param \Zenomania\CoreBundle\Entity\Player $player
     * @param \Zenomania\CoreBundle\Entity\Event $event
     * @param bool $mvp
     * @return EventPlayerForecast
     */
    protected function createForecast(\Zenomania\CoreBundle\Entity\Player $player, \Zenomania\CoreBundle\Entity\Event $event, $mvp = false)
    {
        $forecast = new EventPlayerForecast();
        $forecast->setEvent($event);
        $forecast->setPlayer($player);
        $forecast->setUser($this->getTokenStorage()->getToken()->getUser());
        $forecast->setIsMvp($mvp);
        $forecast->setStatus(EventPlayerForecast::STATUS_NEW);

        return $forecast;
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

    /**
     * @return TokenStorage
     */
    public function getTokenStorage(): TokenStorage
    {
        return $this->tokenStorage;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getForecasts(): \Doctrine\Common\Collections\ArrayCollection
    {
        return $this->forecasts;
    }
}