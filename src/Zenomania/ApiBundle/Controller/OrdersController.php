<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 16.11.17
 * Time: 10:35
 */

namespace Zenomania\ApiBundle\Controller;


use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Zenomania\ApiBundle\Form\Model\Order;
use Zenomania\ApiBundle\Form\OrderType;
use Zenomania\CoreBundle\Entity\OrderCart;

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
}