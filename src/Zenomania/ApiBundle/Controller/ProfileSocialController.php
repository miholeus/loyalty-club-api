<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 04.09.17
 * Time: 16:18
 */

namespace Zenomania\ApiBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Zenomania\ApiBundle\Form\Model\ProfileSocialData;
use Zenomania\ApiBundle\Form\ProfileSocialVkType;
use Zenomania\ApiBundle\Service\Social\Client\ClientException;

class ProfileSocialController extends RestController
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
     *  section="Соц сети",
     *  resource=true,
     *  description="Вконтакте: получение информации о пользователе / шаг 2 (получение данных)",
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
     * @QueryParam(name="access_token", description="Ключ доступа пользователя в Вконтакте")
     * @QueryParam(name="user_id", description="id пользователя в Вконтакте")
     * @QueryParam(name="email", description="email")
     * @QueryParam(name="expires_in", description="Время жизни ключа доступа(0 - бесконечность)")
     *
     * @Route("vk")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getVkontakteAction(Request $request)
    {
        $form = $this->createForm(ProfileSocialVkType::class);
        $this->processForm($request, $form);
        if (!$form->isValid()) {
            throw $this->createFormValidationException($form);
        }

        /**
         * @var ProfileSocialData $data
         */
        $data = $form->getData();

        $serviceSocialInfo = $this->get('api.profile_social_vk');

        try {
            $userInfo = $serviceSocialInfo->getUserInfo($data);
            $userInfo->setUser($this->getUser());
        } catch (ClientException $e) {
            throw new HttpException(400, $e->getMessage(), $e);
        }

        $serviceUpdateSocialInfo = $this->get('api.profile_social_update');
        $serviceUpdateSocialInfo->save($userInfo, $this->getUser());

        $view = $this->view($data);
        return $this->handleView($view);
    }

    /**
     * @ApiDoc(
     *  section="Соц сети",
     *  resource=true,
     *  description="Вконтакте: получение информации о пользователе / шаг 1 (запрос доступа)",
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
     * )
     * @Route("vk/access")
     */
    public function getVkontakteAccessAction()
    {
        $service = $this->get('api.profile_social_vk');
        $link = $service->getAccess($this->getParameter('vk_access_front_url'), $this->getParameter('vk_client_id'));

        $data = [
            'link' => $link
        ];

        $view = $this->view($data);
        return $this->handleView($view);
    }
}