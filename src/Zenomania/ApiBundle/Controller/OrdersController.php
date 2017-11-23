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
     * @Route("orders/{id}")
     *
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getOrdersAction(int $id)
    {
        $order = $this->get('repository.order')->find($id);

        if ($order == null) {
            throw new HttpException(404, 'Заказ не найден');
        }

        if (!$this->isGranted('view', $order)) {
            throw new HttpException(403, 'Доступ запрещен');
        }

        $view = $this->view($order, 200);
        return $this->handleView($view);
    }
}