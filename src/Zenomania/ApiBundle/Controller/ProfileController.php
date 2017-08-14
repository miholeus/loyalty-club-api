<?php
/**
 * @package    Zenomania\ApiBundle\Controller
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class ProfileController extends RestController
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
     *              "id":<user id>
     *          },
     *          "time":<time request>
     *      }
     *
     * @ApiDoc(
     *  section="Профиль",
     *  resource=true,
     *  description="Профиль пользователя",
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
     *  output="\ApiBundle\Service\DataTransferObject\Object\UserValueObject"
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getProfileAction()
    {
        $user = $this->getUser();
        $transformer = $this->get('api.data.transformer.user.profile_transformer');

        $data = $this->getResourceItem($user, $transformer);
        $view = $this->view($data);
        return $this->handleView($view);
    }
}