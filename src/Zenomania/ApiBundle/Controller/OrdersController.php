<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 16.11.17
 * Time: 10:35
 */

namespace Zenomania\ApiBundle\Controller;


use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Request;
use Zenomania\ApiBundle\Form\OrderType;
use FOS\RestBundle\Controller\Annotations\Route;

class OrdersController extends RestController
{
    /**
     * ### Failed Response ###
     *
     *     {
     *       "success": false
     *       "exception": {
     *         "code": <code>,
     *         "message": <message>
     *       }
     *     }
     *
     * ### Success Response ###
     *      {
     *      }
     *
     * @ApiDoc(
     *  section="Заказы",
     *  resource=true,
     *  description="Создать новый заказ",
     *  statusCodes={
     *         200="При успешном создании заказа",
     *         400="Ошибка создания заказа"
     *     },
     *  headers={
     *      {
     *          "name"="X-AUTHORIZE-TOKEN",
     *          "description"="access key header",
     *          "required"=true
     *      }
     *    },
     *  input={
     *     "class"="\Zenomania\ApiBundle\Form\OrderType",
     *     "name"=""
     *     }
     * )
     *
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postOrdersAction(Request $request)
    {
        $service = $this->get('order.service');
        $form = $this->createForm(OrderType::class);
        $this->processForm($request, $form);

        if (!$form->isValid()) {
            throw $this->createFormValidationException($form);
        }

        $data = $service->createOrder($form->getData(), $this->getUser());

        $view = $this->view($data, 201);
        return $this->handleView($view);
    }

    /**
     * ### Failed Response ###
     *
     *     {
     *       "success": false
     *       "exception": {
     *         "code": <code>,
     *         "message": <message>
     *       }
     *     }
     *
     * ### Success Response ###
     *      {
     *          "data":{
     *              "id":<integer>,
     *              "items":[{
     *                  "id":<integer>,
     *                  "title":<string>,
     *                  "quantity":<integer>,
     *               }]
     *              "dt": <string>,
     *              "name": <string>,
     *              "delivery_type": <string>,
     *              "address": <string>,
     *              "address": <string>,
     *              "phone":<integer>,
     *              ]
     *          },
     *          "time":<time request>
     *      }
     *
     * @ApiDoc(
     *  section="Заказы",
     *  resource=true,
     *  description="Вовзращает заказ",
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
     *  output="array"
     * )
     *
     * @Route("orders/{id}")
     *
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getOrderAction(int $id)
    {
        $order = $this->get('repository.order')->find($id);
        $transformer = $this->get('api.data.transformer.order');
        if ($order == null) {
            throw new HttpException(404, 'Заказ не найден');
        }

        if (!$this->isGranted('view', $order)) {
            throw new HttpException(403, 'Доступ запрещен');
        }

        /** @var array $items */
        $items = $this->get('order.service')->getOrderData($order);
        $items['order'] = $order;

        /** @var array $data */
        $data = $this->getResourceItem($items, $transformer);

        $view = $this->view($data, 200);
        return $this->handleView($view);
    }


    /**
     * ### Failed Response ###
     *
     *     {
     *       "success": false
     *       "exception": {
     *         "code": <code>,
     *         "message": <message>
     *       }
     *     }
     *
     * ### Success Response ###
     *      {
     *          "data":{
     *              "id":<integer>,
     *              "items":[{
     *                  "id":<integer>,
     *                  "title":<string>,
     *                  "quantity":<integer>,
     *               }]
     *              "dt": <string>,
     *              "name": <string>,
     *              "delivery_type": <string>,
     *              "address": <string>,
     *              "address": <string>,
     *              "phone":<integer>,
     *              ]
     *          },
     *          "time":<time request>
     *      }
     *
     * @ApiDoc(
     *  section="Заказы",
     *  resource=true,
     *  description="Вовзращает все заказы пользователя",
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
     *  output="array"
     * )
     *
     * @Route("orders")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getOrdersAction()
    {
        $items = $this->get('order.service')->getUserOrders($this->getUser());
        $transformer = $this->get('api.data.transformer.order');

        $data = $this->getResourceCollection($items, $transformer);
        $view = $this->view($data, 200);
        return $this->handleView($view);
    }
}