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
use Symfony\Component\HttpKernel\Exception\HttpException;


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
     *              "emailSend":<bool>
     *          },
     *          "time":<time request>
     *      }
     *
     * @ApiDoc(
     *  section="Приглашения",
     *  resource=true,
     *  description="Отправить приглашение",
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
     * @RequestParam(name="email", description="To which email to send an invite")
     *
     * @param ParamFetcher $paramFetcher
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function postSendInviteAction(ParamFetcher $paramFetcher)
    {
        // Получаем email кому отправляем приглашение
        $emailTo = $paramFetcher->get('email');
        // Пользователь от кого отправляем
        $user = $this->getUser();
        // Подключаем сервис для приглашений
        $inviteService = $this->get('api.invite');

        $mailer = $this->get('mailer');

        // Отправляем приглашение
        $result = $inviteService->sendInvite($emailTo, $user, $mailer);

        if (!$result) {
            throw new HttpException(400, "Приглашение по адресу {$emailTo} отправить не удалось!");
        }

        $data = [
            'emailSend' => $result
        ];

        $view = $this->view($data);

        return $this->handleView($view);

    }
}