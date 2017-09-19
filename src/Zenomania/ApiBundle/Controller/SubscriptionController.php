<?php

namespace Zenomania\ApiBundle\Controller;


use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Zenomania\ApiBundle\Service\Subscriptions;
use Zenomania\CoreBundle\Form\Model\SubscriptionNumber;
use Zenomania\CoreBundle\Form\SubscriptionNumberType;

class SubscriptionController extends RestController
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
     *              "id":<amount ZEN>
     *          },
     *          "time":<time request>
     *      }
     *
     * @ApiDoc(
     *  section="Абонементы",
     *  resource=true,
     *  description="Регистрация абонементов",
     *  statusCodes={
     *         200="При успешной регистрации абонемента",
     *         400="Данный абонемент в системе не зарегистрирован"
     *     },
     *  headers={
     *      {
     *          "name"="X-AUTHORIZE-TOKEN",
     *          "description"="access key header",
     *          "required"=true
     *      }
     *    },
     *  input={
     *     "class"="\Zenomania\CoreBundle\Form\SubscriptionNumberType",
     *     "name"=""
     *  }
     * )
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postSubscriptionRegistrationAction(Request $request)
    {
        $form = $this->createForm(SubscriptionNumberType::class);
        $this->processForm($request, $form);
        if (!$form->isValid()) {
            throw $this->createFormValidationException($form);
        }

        /** @var SubscriptionNumber $subNumber */
        $subNumber = $form->getData();

        /** @var Subscriptions $subService */
        $subService = $this->get('api.subscriptions');

        if (!$subService->isValidCardcode($subNumber)) {
            throw new HttpException(400, "Абонемент {$subNumber->getCardcode()} не найден");
        }

        if ($subService->isSubscriptionRegistered($subNumber)) {
            throw new HttpException(400, "Абонемент {$subNumber->getCardcode()} уже был зарегистрирован ранее");
        }

        $user = $this->getUser();

        $personRepository = $this->get('repository.person_repository');
        $person = $personRepository->findPersonByUser($user);

        $promoActionRepository = $this->get('repository.promo_action_repository');
        $season = $promoActionRepository->findCurrentSeason();

        // Начисляем баллы пользователю User за билет barcode
        $zen = $subService->chargePointForSubsRegistration($person, $season);

        // Заносим регистрацию абонемента cardcode в активность для пользователя User
        $subService->subsRegistration($person, $subNumber);


        $data = [
            'points' => $zen
        ];

        $view = $this->view($data);

        return $this->handleView($view);
    }

}
