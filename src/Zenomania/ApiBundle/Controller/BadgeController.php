<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 27.09.17
 * Time: 15:15
 */

namespace Zenomania\ApiBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Zenomania\ApiBundle\Form\BadgeType;
use FOS\RestBundle\Controller\Annotations\Route;

class BadgeController extends RestController
{
    /**
     * * ### Failed Response ###
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
     *
     *      }
     *
     * @ApiDoc(
     *  section="Бейджи",
     *  resource=true,
     *  description="Бейджи",
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
     * @Route("badge")
     */
    public function putBadgeAction(Request $request)
    {
        $form = $this->createForm(BadgeType::class);
        $this->processForm($request, $form);
        if(!$form->isValid()){
            throw $this->createFormValidationException($form);
        }
        $service = $this->get('api.badge');
        $service->save($form->getData());

        $view = $this->view(null, 204);
        return $this->handleView($view);
    }
}