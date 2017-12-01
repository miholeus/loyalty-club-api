<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 01.12.17
 * Time: 19:11
 */

namespace Zenomania\ApiBundle\Controller;


use FOS\RestBundle\Request\ParamFetcher;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\QueryParam;

class ProductController extends RestController
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
     *          "data":{
     *              "type": {
     *                  "id": <integer>
     *                  "title": <string>
     *                  "sort": <integer>
     *              }
     *              "title": <string>,
     *              "code": <string>,
     *              "points": <integer>,
     *              "max_points": <integer>,
     *              "photo": <string>,
     *              "sort": <integer>,
     *          },
     *          "time":<time request>
     *      }
     *
     * @ApiDoc(
     *  section="Бейджи",
     *  resource=true,
     *  description="Бейджи пользователй",
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
     * @QueryParam(name="period", requirements="^(month|season)$", allowBlank=true, nullable=true, description="Сделать выборку за месяц(month)|сезон(season)|все()")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getProductAction(ParamFetcher $paramFetcher)
    {
        $transformer = $this->get('api.data.transformer.product');
        $service = $this->get('api.product.service');

        $items = $service->getProducts();

        $data = $this->getResourceItem($items, $transformer);

        $view = $this->view($data);
        return $this->handleView($view);
    }
}