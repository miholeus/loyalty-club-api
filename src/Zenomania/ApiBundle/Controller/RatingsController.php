<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 25.09.17
 * Time: 15:29
 */

namespace Zenomania\ApiBundle\Controller;

use FOS\RestBundle\Request\ParamFetcher;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Zenomania\ApiBundle\Request\Filter\RatingsFilter;

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
     *          }
     *      }
     *
     * ### Success Response ###
     *      {
     *          "data":{
     *              "position":<integer>,
     *              "points": <integer>,
     *              "user": [
     *                  "id": <integer>,
     *                  "photo": <string>,
     *                  "first_name": <string>,
     *                  "last_name": <string>,
     *                  "middle_name": <string>
     *              ]
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
     * @QueryParam(name="period", requirements="^(month|season)$", allowBlank=true, nullable=true, description="Сделать выборку за месяц(month)|сезон(season)|все()")
     *
     * @param ParamFetcher $paramFetcher
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getRatingsAction(ParamFetcher $paramFetcher)
    {
        $transformer = $this->get('api.data.transformer.ratings');
        $service = $this->get('api.ratings');

        $params = $this->getParams($paramFetcher, 'ratings');
        $params['period'] = !empty($params['period']) ? $params['period'] : null;

        $filter = new RatingsFilter($params);

        /** @var array $items */
        $items = $service->getRatings($filter);
        /** @var array $data */
        $data = $this->getResourceCollection($items, $transformer);

        $view = $this->view($data);
        return $this->handleView($view);
    }
}