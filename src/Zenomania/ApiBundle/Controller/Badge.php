<?php
/**
 * Created by PhpStorm.
 * User: igorvolkov
 * Date: 27.10.17
 * Time: 11:41
 */

namespace Zenomania\ApiBundle\Controller;

use FOS\RestBundle\Request\ParamFetcher;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Zenomania\ApiBundle\Request\Filter\BadgeFilter;

class Badge extends RestController
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
     *              "type_id":<string>,
     *              "type_title": <string>,
     *              "badge_title": <string>,
     *              "badge_code": <string>,
     *              "points": <integer>,
     *              "max_points": <integer>,
     *              "photo": <string>,
     *              "type_sort": <integer>,
     *              "badge_sort": <integer>,
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
    public function getBadgeAction(ParamFetcher $paramFetcher)
    {
        $transformer = $this->get('api.data.transformer.badges');
        $service = $this->get('api.badge');

        $params = $this->getParams($paramFetcher, 'badge');
        $params['period'] = !empty($params['period']) ? $params['period'] : null;
        $params['user'] = $this->getUser();

        $filter = new BadgeFilter($params);

        $items = $service->getBadges($filter);

        $data = $this->getResourceCollection($items, $transformer);

        $view = $this->view($data);
        return $this->handleView($view);
    }
}