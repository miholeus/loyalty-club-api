<?php
/**
 * @package    Zenomania\ApiBundle\Controller
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Zenomania\ApiBundle\Request\Filter\UserFilter;
use Zenomania\CoreBundle\Entity\User;

class UserController extends RestController
{

    /**
     *
     * ### Failed Response ###
     *      {
     *          {
     *              "success": false,
     *              "exception": {
     *                  "code": 400,
     *                  "message": "Validation Failed"
     *              },
     *              "errors": {
     *                  "user":{
     *                      "errors":[
     *                          <errorMessage 1>,
     *                          <...>,
     *                          <errorMessage N>
     *                      ],
     *                      "children": {
     *                           <field_name>: {
     *                              "errors": [
     *                                  <errorMessage 1>,
     *                                  <...>,
     *                                  <errorMessage N>
     *                              ],
     *                              "children": null
     *                          }
     *                      }
     *                  }
     *              }
     *          }
     *      }
     * @ApiDoc(
     *  section="Пользователи",
     *  resource=true,
     *  description="Список пользователей",
     *  statusCodes={
     *         200="При успешном выполнении запроса",
     *         400="Ошибка при выполнении запроса",
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
     * @QueryParam(name="date_start", allowBlank=true, description="Дата начала")
     * @QueryParam(name="date_end", allowBlank=true, description="Дата окончания")
     *
     * @param ParamFetcher $paramFetcher
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getUsersAction(ParamFetcher $paramFetcher)
    {
        $transformer = $this->get('api.data.transformer.user.user_info_transformer');
        $userService = $this->get('user.service');

        $params = $this->getParams($paramFetcher, User::class);
        $filter = new UserFilter($params);

        $users = $userService->search($filter);
        $data = $this->getResourceCollection($users, $transformer);
        $view = $this->view($data);
        return $this->handleView($view);
    }
}