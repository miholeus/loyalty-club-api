<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 28.08.2017
 * Time: 12:13
 */

namespace Zenomania\ApiBundle\Controller;

use FOS\RestBundle\Request\ParamFetcher;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Zenomania\CoreBundle\Entity\User;

class InviteController extends RestController
{

    /**
     * ### Failed Response ###
     *
     *     {
     *       "success": false
     *       "exception": {
     *         "code": <code>,
     *         "message": <message>
     *       }
     *     }
     *
     * ### Success Response ###
     *      {
     *          "data":{
     *              "link":<registration url>
     *          },
     *          "time":<time request>
     *      }
     *
     * @ApiDoc(
     *  section="Приглашения",
     *  resource=true,
     *  description="Отправить приглашение другу",
     *  statusCodes={
     *         200="При успешной отправки приглашения",
     *         400="Приглашение не удалось отправить"
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
     *
     * @RequestParam(name="email", description="To which email to send an invite", allowBlank=false)
     *
     * @param ParamFetcher $paramFetcher
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postInviteAction(ParamFetcher $paramFetcher, Request $request)
    {
        // Получаем email кому отправляем приглашение
        $emailTo = $paramFetcher->get('email');
        // Пользователь от кого отправляем
        /** @var User $user */
        $user = $this->getUser();
        // Подключаем сервис для приглашений
        $invite = $this->get('api.invite_service');

        $bonus = $this->get('api.invite_bonus_service');

        // Отправляем приглашение
        $url = $this->getParameter('registration_url');
        $code = $bonus->getCodeForUser($user);
        $result = $invite->send($emailTo, $code, $url);

        if (!$result) {
            throw new HttpException(400, "Приглашение по адресу {$emailTo} отправить не удалось!");
        }

        $data = ['link' => sprintf("%s://%s?ref=%s", $request->getScheme(), $url, $code)];

        $view = $this->view($data);

        return $this->handleView($view);

    }

    /**
     * ### Failed Response ###
     *
     *     {
     *       "success": false
     *       "exception": {
     *         "code": <code>,
     *         "message": <message>
     *       }
     *     }
     *
     * ### Success Response ###
     *      {
     *          "data":{
     *              "link":<registration url>
     *          },
     *          "time":<time request>
     *      }
     *
     * @ApiDoc(
     *  section="Приглашения",
     *  resource=true,
     *  description="Получить ссылку для отправки приглашения",
     *  statusCodes={
     *         200="При успешном ответе",
     *         400="Ошибка"
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
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getProfileInviteAction(Request $request)
    {
        /** @var User $user */
        $user = $this->getUser();

        $bonus = $this->get('api.invite_bonus_service');

        $url = $this->getParameter('registration_url');
        $code = $bonus->getCodeForUser($user);

        $data = ['link' => sprintf("%s://%s?ref=%s", $request->getScheme(), $url, $code)];

        $view = $this->view($data);

        return $this->handleView($view);

    }
}