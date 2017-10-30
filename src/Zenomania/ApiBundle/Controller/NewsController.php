<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 30.10.17
 * Time: 11:02
 */

namespace Zenomania\ApiBundle\Controller;

use FOS\RestBundle\Request\ParamFetcher;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Zenomania\ApiBundle\Request\Filter\NewsFilter;

class NewsController extends RestController
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
     *              "id":<integer>,
     *              "text": <string>,
     *              "tags": <array>,
     *              "photo": <string>,
     *              "video": <string>,
     *              "dt": <string>,
     *              "vk_share_link": <string>,
     *              ]
     *          },
     *          "time":<time request>
     *      }
     *
     * @ApiDoc(
     *  section="Новости",
     *  resource=true,
     *  description="Новости",
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
     * @QueryParam(name="limit", default="5", requirements="\d+", description="Количество запрашиваемых новостей" )
     * @QueryParam(name="offset", nullable=true, requirements="\d+", description="Смещение, с которого нужно начать просмотр")
     *
     * @param ParamFetcher $paramFetcher
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getNewsAction(ParamFetcher $paramFetcher)
    {
        $transformer = $this->get('api.data.transformer.news');
        $service = $this->get('api.news');

        $params = $this->getParams($paramFetcher, 'news');

        $filter = new NewsFilter($params);

        /** @var array $items */
        $items = $service->getNews($filter);

        /** @var array $data */
        $data = $this->getResourceCollection($items, $transformer);

        $view = $this->view($data);
        return $this->handleView($view);
    }
}