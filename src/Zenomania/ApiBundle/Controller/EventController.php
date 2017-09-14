<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 14.09.2017
 * Time: 10:58
 */

namespace Zenomania\ApiBundle\Controller;


use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Zenomania\CoreBundle\Entity\Event;
use Symfony\Component\HttpKernel\Exception\HttpException;

class EventController extends RestController
{
    /**
     *
     * ### Failed Response ###
     *      {
     *          {
     *              "success": false,
     *              "exception": {
     *                  "code": 400,
     *                  "message": "Bad Request"
     *              },
     *              "errors": null
     *      }
     *
     * ### Success Response ###
     *      {
     *          "data":{
     *              "club_home":<club home>
     *              "club_guest":<club guest>
     *              "place":<place>
     *              "name":<name>
     *              "score_home":<score home>
     *              "score_guest":<score guest>
     *              "score_in_round":<score in round>
     *              "mvp":<mvp>
     *          },
     *          "time":<time request>
     *      }
     *
     * @ApiDoc(
     *  section="Мероприятия",
     *  resource=true,
     *  description="Данные по мероприятиям",
     *  statusCodes={
     *         200="При успешном запросе",
     *         400="Ошибка запроса"
     *     },
     *  headers={
     *      {
     *          "name"="X-AUTHORIZE-TOKEN",
     *          "description"="access key header",
     *          "required"=true
     *      }
     *    },
     *  output="\ApiBundle\Service\DataTransferObject\Object\UserValueObject"
     * )
     *
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getEventAction()
    {
        $request = Request::createFromGlobals();
        $eventId = $request->query->get('eventid');

        if (empty($eventId)) {
            throw new HttpException(400, "Не задан id мероприятия");
        }

        $eventRepository = $this->get('repository.event_repository');
        /** @var Event $event */
        $event = $eventRepository->findEventById($eventId);

        if (empty($event)) {
            throw new HttpException(400, "Не найдены данные для мероприятия с id = {$eventId}");
        }

        $transformer = $this->get('api.data.transformer.event.transformer');

        $data = $this->getResourceItem($event, $transformer);
        $view = $this->view($data);
        return $this->handleView($view);
    }

    /**
     *
     * ### Failed Response ###
     *      {
     *          {
     *              "success": false,
     *              "exception": {
     *                  "code": 400,
     *                  "message": "Bad Request"
     *              },
     *              "errors": null
     *      }
     *
     * ### Success Response ###
     *      {
     *          "data":{
     *              "events":<events>
     *          },
     *          "time":<time request>
     *      }
     *
     * @ApiDoc(
     *  section="Мероприятия",
     *  resource=true,
     *  description="Данные по последним мероприятиям",
     *  statusCodes={
     *         200="При успешном запросе",
     *         400="Ошибка запроса"
     *     },
     *  headers={
     *      {
     *          "name"="X-AUTHORIZE-TOKEN",
     *          "description"="access key header",
     *          "required"=true
     *      }
     *    },
     *  output="\ApiBundle\Service\DataTransferObject\Object\UserValueObject"
     * )
     *
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getEventLastAction()
    {
        $request = Request::createFromGlobals();
        $count = $request->query->get('count');

        if (empty($count)) {
            $count = 15;
        }

        $eventRepository = $this->get('repository.event_repository');
        /** @var Event $event */
        $events = $eventRepository->findLastEvents($count);

        if (empty($events)) {
            throw new HttpException(400, "Не найдены мероприятия в базе");
        }

        $transformer = $this->get('api.data.transformer.event.transformer');
        $dataEvent = [];
        foreach ($events as $event) {
            $dataEvent[] = $this->getResourceItem($event, $transformer);
        }

        $data = [
            'events' => $dataEvent
        ];

        $view = $this->view($data);
        return $this->handleView($view);
    }
}