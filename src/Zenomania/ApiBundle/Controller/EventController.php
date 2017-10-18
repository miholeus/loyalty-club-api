<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 14.09.2017
 * Time: 10:58
 */

namespace Zenomania\ApiBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\Route;
use Zenomania\ApiBundle\Form\{
    EventPlayerPredictionType, EventScorePredictionType
};
use Zenomania\ApiBundle\Service\Exception\EntityNotFoundException;
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
     *    }
     * )
     *
     * @Route(requirements={"event": "\d+"})
     *
     * @param Event $event
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getEventAction(Event $event = null)
    {
        if (null === $event) {
            throw new HttpException(400, "Мероприятие не найдено");
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
     *                  "code": 404,
     *                  "message": "Event Not Found"
     *              },
     *              "errors": null
     *      }
     *
     * ### Success Response ###
     *      {
     *          "club_guest": {
     *              "id": <integer>,
     *              "logo": <string>,
     *              "name": <string>
     *          },
     *          "club_home": {
     *              "id": <integer>,
     *              "logo": <string>,
     *              "name": <string>
     *          },
     *          "date": <timestamp>,
     *          "id": <integer>,
     *          "name": <string>,
     *          "players": [
     *              {
     *                  "first_name": <string>,
     *                  "id": <integer>,
     *                  "last_name": <string>,
     *                  "middle_name": <string>,
     *                  "photo": <string>
     *              }
     *          ]
     *          "time":<time request>
     *      }
     *
     * @ApiDoc(
     *  section="Прогнозы",
     *  resource=true,
     *  description="Данные по предстоящему мероприятию",
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
     *    }
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getEventsNextAction()
    {
        $service = $this->get('event.service');
        try {
            $event = $service->nextEvent();
        } catch (EntityNotFoundException $e) {
            throw new HttpException(404, $e->getMessage(), $e);
        }

        $transformer = $this->get('api.data.transformer.event.prediction');

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
     *    }
     * )
     *
     * @QueryParam(name="limit", description="Количество запрашиваемых мероприятий")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getEventsAction(Request $request)
    {
        $limit = $request->query->get('count', 15);
        if ($limit > 100) {
            $limit = 100;
        }

        $eventRepository = $this->get('repository.event_repository');
        /** @var Event $event */
        $events = $eventRepository->findLastEvents($limit);

        $transformer = $this->get('api.data.transformer.event.transformer');
        $dataEvent = $this->getResourceCollection($events, $transformer);

        $view = $this->view($dataEvent);
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
     *              "id":<forecast id>
     *          },
     *          "time":<time request>
     *      }
     *
     * @ApiDoc(
     *  section="Прогнозы",
     *  resource=true,
     *  description="Прогноз счета в партиях",
     *  statusCodes={
     *         204="При успешном запросе",
     *         400="Ошибка запроса"
     *     },
     *  headers={
     *      {
     *          "name"="X-AUTHORIZE-TOKEN",
     *          "description"="access key header",
     *          "required"=true
     *      }
     *    },
     *  input={
     *     "class"="\Zenomania\ApiBundle\Form\EventScorePredictionType",
     *     "name"=""
     *     }
     * )
     *
     * @Route(requirements={"event": "\d+"})
     *
     * @param Event $event
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postEventPredictionAction(Event $event = null, Request $request)
    {
        if (null === $event) {
            throw new HttpException(400, "Мероприятие не найдено");
        }

        $form = $this->createForm(EventScorePredictionType::class);
        $this->processForm($request, $form);

        if (!$form->isValid()) {
            throw $this->createFormValidationException($form);
        }

        $service = $this->get('event_forecast.service');

        if ($service->hasActiveForecast($event, $this->getUser())) {
            throw new HttpException(400, "Вы уже сделали прогноз");
        }

        $forecast = $service->getEventForecastByModel($form->getData());
        $forecast->setEvent($event);
        $forecast->setUser($this->getUser());

        $service->save($forecast);

        $data = [
            'id' => $forecast->getId()
        ];

        $view = $this->view($data, 200);
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
     *              "errors": {
     *                  "event_player_prediction": {
     *                      "children": {
     *                          "players": {
     *                              "errors": [
     *                                  "This value is not valid."
     *                              ]
     *                          }
     *                      }
     *              }
     *          }
     *      }
     *
     * ### Success Response ###
     *      {
     *          "data":null
     *          "time":<time request>
     *      }
     *
     * @ApiDoc(
     *  section="Прогнозы",
     *  resource=true,
     *  description="Прогноз игроков в матче",
     *  statusCodes={
     *         204="При успешном запросе",
     *         400="Ошибка запроса"
     *     },
     *  headers={
     *      {
     *          "name"="X-AUTHORIZE-TOKEN",
     *          "description"="access key header",
     *          "required"=true
     *      }
     *    }
     * )
     *
     * @Route(requirements={"event": "\d+"})
     * @RequestParam(name="players", description="Список игроков (указывается через запятую идентификаторы)")
     * @RequestParam(name="mvp", description="Ид самого важного игрока")
     *
     * @param Event $event
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postEventPlayerAction(Event $event = null, Request $request)
    {
        if (null === $event) {
            throw new HttpException(400, "Мероприятие не найдено");
        }

        $request->request->set('event', $event->getId());
        $request->attributes->remove('event');

        $form = $this->createForm(EventPlayerPredictionType::class);
        $this->processForm($request, $form);

        if (!$form->isValid()) {
            throw $this->createFormValidationException($form);
        }

        $service = $this->get('event_forecast.service');

        if ($service->hasActivePlayerForecast($event, $this->getUser())) {
            throw new HttpException(400, "Вы уже сделали прогноз");
        }

        /** @var \Zenomania\ApiBundle\Form\EventPlayerPredictionType $data */
        $data = $form->getData();
        $forecasts = $data->getForecasts();

        $service->savePlayerForecasts($forecasts);

        $view = $this->view(null, 204);
        return $this->handleView($view);
    }
}