<?php
/**
 * @package    Zenomania\CoreBundle\Entity\Listener
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */


namespace Zenomania\CoreBundle\Entity\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Exception\ValidatorException;
use Zenomania\CoreBundle\Entity\Player;
use Zenomania\CoreBundle\Entity\Traits\ValidatorTrait;
use Zenomania\CoreBundle\Service\Exception\UploadFileException;

class PlayerListener
{
    use ValidatorTrait;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param Player $player
     * @return array|null
     */
    protected function getValidationGroups(Player $player)
    {
        $groups = null;
        if ($player->getPhoto() && $player->getPhoto() instanceof File) {
            $groups = ['Default', 'upload'];
        }
        return $groups;
    }

    /**
     * @param Player $player
     * @param LifecycleEventArgs $event
     * @throws ValidatorException
     */
    public function preUpdate(Player $player, LifecycleEventArgs $event)
    {
        $groups = $this->getValidationGroups($player);
        $this->validate($player, null, $groups);

        $this->convertFilePathToRelative($player);
    }

    public function prePersist(Player $player, LifecycleEventArgs $event)
    {
        $groups = $this->getValidationGroups($player);
        $this->validate($player, null, $groups);

        $this->convertFilePathToRelative($player);
    }

    /**
     * Формируем пути к файлам фотографий пользователя
     *
     * @param Player $player
     * @throws UploadFileException
     */
    protected function convertFilePathToRelative(Player $player)
    {
        $rootDirectory = $this->getContainer()->getParameter('player_upload_photo_dir');
        if ($player->getPhoto() instanceof File && $avatar = $player->getPhoto()) {
            $pos = strpos($avatar->getRealPath(), $rootDirectory);
            if (false !== $pos) {
                $path = substr($avatar->getRealPath(), $pos-1);
                $player->setPhoto($path);
            }
        }
    }
}