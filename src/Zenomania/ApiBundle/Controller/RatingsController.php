<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 25.09.17
 * Time: 15:29
 */

namespace Zenomania\ApiBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Symfony\Component\HttpFoundation\Request;
use Zenomania\ApiBundle\Form\RatingsType;

class RatingsController extends RestController
{
    /**
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
     *              "position":<integer>,
     *              "points": <integer>,
     *              "user_id": <string>,
     *              "avatar": <string>,
     *              "firstname": <string>,
     *              "lastname": <string>,
     *              "middlename": <string>,
     *              "middle_name": <string>
     *          },
     *          "time":<time request>
     *      }
     *
     * @ApiDoc(
     *  section="Рейтинг",
     *  resource=true,
     *  description="Общий рейтинг пользователй",
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
     * @QueryParam(name="limit", default="20", requirements="\d+", description="Количество запрашиваемых записей" )
     * @QueryParam(name="offset", nullable=true, requirements="\d+", description="Смещение, с которого нужно начать просмотр")
     * @QueryParam(name="period", description="За какой период сделать выборку месяц(month)|сезон(season)|за все время()")
     *
     * @Route("ratings")
     */
    public function getRatingsAction(Request $request)
    {
        $form = $this->createForm(RatingsType::class);
        $this->processForm($request, $form);
        if (!$form->isValid()) {
            throw $this->createFormValidationException($form);
        }

        $ratingsService = $this->get('api.ratings');
        /** @var array $data */
        $data = $ratingsService->getRatings($form->getData());

        $view = $this->view($data);
        return $this->handleView($view);
    }
}