<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 27.11.17
 * Time: 17:56
 */

namespace Zenomania\CoreBundle\Entity\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Zenomania\CoreBundle\Entity\PersonPoints;
use Zenomania\CoreBundle\Entity\Traits\UserAwareTrait;
use Zenomania\CoreBundle\Entity\Traits\ValidatorTrait;
use Zenomania\CoreBundle\Event\NotificationInterface;
use Zenomania\CoreBundle\Event\User\ForecastEvent;
use Zenomania\CoreBundle\Event\User\RepostEvent;
use Zenomania\CoreBundle\Service\Traits\EventsAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PersonPointsListener
{
    use ValidatorTrait;
    use UserAwareTrait;
    use EventsAwareTrait;

    /**
     * @var NotificationInterface
     */
    protected $notificationManager;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->notificationManager = $container->get('event.notification_manager');
    }

    /**
     * @param PersonPoints $personPoints
     * @param LifecycleEventArgs $event
     */
    public function prePersist(PersonPoints $personPoints, LifecycleEventArgs $event)
    {
        switch ($personPoints->getType()) {
            case PersonPoints::TYPE_FORECAST_WINNER_MATCH_RESULT:
                $event = new ForecastEvent();
                $event->setArgument('user', $personPoints->getUser());
                $this->attachEvent($event);
                $this->updateEvents();
                break;
            case PersonPoints::TYPE_REPOST:
                $event = new RepostEvent();
                $event->setArgument('personPoints', $personPoints);
                $this->attachEvent($event);
                $this->updateEvents();
                break;
        }
    }
}