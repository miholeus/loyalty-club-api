<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 14.08.2017
 * Time: 17:40
 */

namespace Zenomania\ApiBundle\Controller;


use FOS\RestBundle\Request\ParamFetcher;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Zenomania\ApiBundle\Service\Tickets;

class TicketController extends RestController
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
     *              "id":<user id>
     *          },
     *          "time":<time request>
     *      }
     *
     * @ApiDoc(
     *  section="Билеты",
     *  resource=true,
     *  description="Регистрация билетов",
     *  statusCodes={
     *         200="При успешной регистрации билетам",
     *         400="По данному билету посещение мероприятия не зафиксировано"
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
     * @RequestParam(name="barcode", description="Barcode Ticket")
     *
     * @param ParamFetcher $paramFetcher
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postTicketRegistrationAction(ParamFetcher $paramFetcher)
    {
        $barcode = $paramFetcher->get('barcode');
        /** @var Tickets $ticketsService */
        $ticketsService = $this->get('api.tickets');

        if (!$ticketsService->isValidBarcode($barcode)) {
            throw new HttpException(400, "По данному билету {$barcode} посещение мероприятия не зафиксировано.");
        }

        if ($ticketsService->isTicketRegistered($barcode)) {
            throw new HttpException(400, "Данный билет {$barcode} уже был зарегистрирован ранее.");
        }

        $user = $this->getUser();

        $personRepository = $this->get('repository.person_repository');
        $person = $personRepository->findPersonByUser($user);

        $promoActionRepository = $this->get('repository.promo_action_repository');
        $season = $promoActionRepository->findCurrentSeason();

        // Начисляем баллы пользователю User за билет barcode
        $zen = $ticketsService->chargePointForTicketRegistration($person, $season);

        // Заносим регистрацию билета barcode в активность для пользователя User
        $ticketsService->ticketRegistration($person, $barcode);

        $data = [
            'points' => $zen
        ];

        $view = $this->view($data);

        return $this->handleView($view);
    }
}