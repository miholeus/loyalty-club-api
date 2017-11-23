<?php
/**
 * @package    Zenomania\ApiBundle\Service\Afr\Handler
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service\Afr\Handler;

use Monolog\Logger;
use Zenomania\CoreBundle\Entity\Club;
use Zenomania\CoreBundle\Event\Club\ClubReceivedEvent;
use Zenomania\CoreBundle\Repository\ClubRepository;
use Zenomania\CoreBundle\Service\Traits\EventsAwareTrait;
use Zenomania\CoreBundle\Event\NotificationInterface;

class ClubsHandler
{
    use EventsAwareTrait;
    /**
     * @var Logger
     */
    private $logger;
    /**
     * @var ClubRepository
     */
    private $repository;

    public function __construct(Logger $logger, ClubRepository $repository, NotificationInterface $notification)
    {
        $this->logger = $logger;
        $this->repository = $repository;
        $this->notificationManager = $notification;
    }

    /**
     * Handle data
     *
     * @param array $data
     */
    public function handle(array $data)
    {
        foreach ($data as $item) {
            $this->handleItem($item);
        }
    }

    /**
     * Handle single club
     *
     * @param array $item
     */
    protected function handleItem(array $item)
    {
        $this->getLogger()->info(sprintf("Обрабатываем клуб %s [%d]", $item['name'], $item['id']));

        $club = $this->getRepository()->findByNameAndExternalId($item['name'], $item['id']);
        $event = null;
        if (null === $club) {
            $this->getLogger()->info(sprintf("Создаем новый клуб %s", $item['name']));
            $club = new Club();
            $club->setExternalId($item['id']);
            $club->setName($item['name']);
            $club->setSite($item['site']);

            $this->getRepository()->save($club);
            $event = new ClubReceivedEvent($club);
            $event->setArgument('logo', $item['logo']);

            $this->attachEvent($event);
            $this->getLogger()->info(sprintf("Поставили задачу в очередь на закачку логотипа для клуба %s", $club->getName()));
        } else {
            $club->setExternalId($item['id']);
            $this->getRepository()->save($club);
            if (!$club->getLogoImg()) {
                $event = new ClubReceivedEvent($club);
                $event->setArgument('logo', $item['logo']);
                $this->attachEvent($event);
                $this->getLogger()->info(sprintf("Поставили задачу в очередь на закачку логотипа для клуба %s", $club->getName()));
            }
        }

        $this->updateEvents();
    }
    /**
     * @return Logger
     */
    public function getLogger(): Logger
    {
        return $this->logger;
    }

    /**
     * @return ClubRepository
     */
    public function getRepository(): ClubRepository
    {
        return $this->repository;
    }
}