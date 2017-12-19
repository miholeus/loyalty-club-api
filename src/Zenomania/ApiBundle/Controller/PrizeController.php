<?php
/**
 * Created by PhpStorm.
 * User: igorvolkov
 * Date: 19.12.2017
 * Time: 18:24
 */

namespace Zenomania\ApiBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class PrizeController extends RestController
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
     *          }
     *      }
     *
     * ### Success Response ###
     *      {
     *          "data":[{
     *              "id": <integer>
     *              "title": <string>,
     *              "photo": <string>,
     *              "category": {
     *                  "id": <integer>,
     *                  "title": <string>,
     *              }
     *          }],
     *          "time":<time request>
     *      }
     *
     * @ApiDoc(
     *  section="Призы",
     *  resource=true,
     *  description="Призы пользователй",
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
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getPrizesAction()
    {
        $transformer = $this->get('api.data.transformer.prize');
        $service = $this->get('api.prize');
        $items = $service->getPrizes($this->getUser());

        $data = $this->getResourceCollection($items, $transformer);
        $view = $this->view($data);
        return $this->handleView($view);
    }
}