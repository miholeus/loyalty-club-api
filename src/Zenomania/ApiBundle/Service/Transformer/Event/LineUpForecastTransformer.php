<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 25.10.2017
 * Time: 13:04
 */

namespace Zenomania\ApiBundle\Service\Transformer\Event;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Zenomania\ApiBundle\Service\Transformer\TransformerAbstract;
use Zenomania\CoreBundle\Entity\Event;
use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Repository\EventPlayerForecastRepository;
use Zenomania\CoreBundle\Service\Utils\HostBasedUrl;

class LineUpForecastTransformer extends TransformerAbstract
{
    /**
     * @var HostBasedUrl
     */
    protected $url;
    /**
     * @var EventPlayerForecastRepository
     */
    protected $repository;
    /**
     * @var TokenStorage
     */
    protected $tokenStorage;

    public function __construct(
        HostBasedUrl $url,
        EventPlayerForecastRepository $repository,
        TokenStorage $tokenStorage
    )
    {
        $this->url = $url;
        $this->repository = $repository;
        $this->tokenStorage = $tokenStorage;
    }

    public function transform(Event $event)
    {
        $user = $this->getUser();
        $playerForecast = $this->getRepository()->findBy(['event' => $event, 'user' => $user, 'isMvp' => false]);
        return $this->collection($playerForecast, new LineUpPlayerForecastTransformer($this->url));
    }

    /**
     * Возвращает текущего пользователя
     *
     * @return User
     */
    protected function getUser()
    {
        return $this->tokenStorage->getToken()->getUser();
    }
    /**
     * @return EventPlayerForecastRepository
     */
    public function getRepository(): EventPlayerForecastRepository
    {
        return $this->repository;
    }
}