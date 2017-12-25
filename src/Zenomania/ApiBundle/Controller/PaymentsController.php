<?php
/**
 * Created by PhpStorm.
 * User: igorvolkov
 * Date: 25.12.2017
 * Time: 23:30
 */

namespace Zenomania\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Zenomania\ApiBundle\Form\PaymentType;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\Route;

class PaymentsController extends RestController
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
     *              "id":<forecast id>
     *          },
     *          "time":<time request>
     *      }
     *
     * @ApiDoc(
     *  section="Транзакции",
     *  resource=true,
     *  description="Списание баллов",
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
     * @Route(requirements={"amount": "\d+"})
     * @Route("/payments/debits/{amount}")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function patchPaymentsAction(int $amount, Request $request)
    {
        $this->getUser();
        $service = $this->get('api.payments');
        $transformer = $this->get('api.data.transformer.payments.debit');

        $item = $service->debit($amount, $this->getUser());
        $data = $this->getResourceItem($item, $transformer);

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
     *  section="Транзакции",
     *  resource=true,
     *  description="Совершение покупки",
     *  statusCodes={
     *         201="При успешном запросе",
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
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postPaymentsAction(Request $request)
    {
        $service = $this->get('api.payments');
        $transformer = $this->get('api.data.transformer.payments');

        $servicePersonPoint = $this->get('api.person_points');

        $form = $this->createForm(PaymentType::class);

        $this->processForm($request, $form);

        if (!$form->isValid()) {
            throw $this->createFormValidationException($form);
        }

        $item = $service->credit($form->getData(), $this->getUser());
        $data = $this->getResourceItem($item, $transformer);

        $servicePersonPoint->getRepository()->givePointsForOrderInternetShop($form->getData(), $this->getUser());

        $view = $this->view($data, 201);
        return $this->handleView($view);
    }
}

