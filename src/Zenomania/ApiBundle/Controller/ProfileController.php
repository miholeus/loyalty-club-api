<?php
/**
 * @package    Zenomania\ApiBundle\Controller
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Zenomania\ApiBundle\Form\UserProfileType;
use Zenomania\CoreBundle\Entity\User;
use Zenomania\ApiBundle\Form\Model\UserProfile;

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
     *              "id":<user id>,
     *              "avatar": <string>,
     *              "avatar_small": <string>,
     *              "birth_date": <string>,
     *              "email": <string>,
     *              "first_name": <string>,
     *              "last_name": <string>,
     *              "middle_name": <string>,
     *              "login": <string>,
     *              "phone": <string>,
     *              "highest_place": <integer>,
     *              "rating": <integer>
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
     *  output="\Zenomania\ApiBundle\Service\Transformer\User\UserProfileTransformer"
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
     *
     *      }
     *
     * @ApiDoc(
     *  section="Профиль",
     *  resource=true,
     *  description="Редактирование Профиля пользователя",
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
     *
     * @Rest\RequestParam(name="first_name", description="Имя")
     * @Rest\RequestParam(name="last_name", description="Фамилия")
     * @Rest\RequestParam(name="middle_name", description="Отчество")
     * @Rest\RequestParam(name="phone", description="Номер телефона")
     * @Rest\RequestParam(name="email", description="Электронная почта")
     * @Rest\RequestParam(name="city", description="Город")
     * @Rest\RequestParam(name="district", description="Район")
     * @Rest\RequestParam(name="birthDate", description="Дата рождения")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function putProfileAction(Request $request)
    {
        $form = $this->createForm(UserProfileType::class);
        $this->processForm($request, $form);
        if (!$form->isValid()) {
            throw $this->createFormValidationException($form);
        }
        $data = $form->getData();
        $service = $this->get('api.user_profile');
        $data = $service->save($data, $this->getUser());

        $view = $this->view($data);
        return $this->handleView($view);
    }
}