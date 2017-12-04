<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 01.12.17
 * Time: 19:11
 */

namespace Zenomania\ApiBundle\Controller;


use Nelmio\ApiDocBundle\Annotation\ApiDoc;

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
     *          "data":[{
     *              "id":<integer>,
     *              "title":<string>,
     *              "products":[{
     *                  "id":<integer>,
     *                  "title":<string>,
     *                  "description":<integer>,
     *                  "photo":<integer>,
     *                  "price":<integer>,
     *               }]
     *          }],
     *          "time":<time request>
     *      }
     *
     * @ApiDoc(
     *  section="Товары",
     *  resource=true,
     *  description="Товары за зены",
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
    public function getProductAction()
    {
        $transformer = $this->get('api.data.transformer.product');
        $service = $this->get('api.product.service');

        $items = $service->getProducts();

        $data = $this->getResourceItem($items, $transformer);

        $view = $this->view($data);
        return $this->handleView($view);
    }
}