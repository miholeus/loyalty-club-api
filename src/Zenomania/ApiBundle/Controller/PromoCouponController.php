<?php

namespace Zenomania\ApiBundle\Controller;


use FOS\RestBundle\Request\ParamFetcher;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Zenomania\ApiBundle\Service\Exception\EntityNotFoundException;
use Zenomania\ApiBundle\Service\PromoCoupon;

class PromoCouponController extends RestController
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
     *  section="Промо-коды",
     *  resource=true,
     *  description="Регистрация промо-кодов",
     *  statusCodes={
     *         200="При успешной регистрации промо-кода",
     *         400="Данный промо-код в системе не зарегистрирован"
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
     * @RequestParam(name="number", description="Number promo-coupon")
     *
     * @param ParamFetcher $paramFetcher
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postPromoCouponRegistrationAction(ParamFetcher $paramFetcher)
    {
        $numberPromoCoupon = $paramFetcher->get('number');
        /** @var PromoCoupon $promoCouponService */
        $promoCouponService = $this->get('api.promocoupon');

        if (!$promoCouponService->isValidNumber($numberPromoCoupon)) {
            throw new HttpException(400, "Промо-код с номером {$numberPromoCoupon} не найден.");
        }

        if ($promoCouponService->isPromoCouponRegistered($numberPromoCoupon)) {
            throw new HttpException(400, "Промо-код с номером {$numberPromoCoupon} уже был использован.");
        }

        $user = $this->getUser();

        try {
            $zen = $promoCouponService->promoCouponRegistration($numberPromoCoupon, $user);
        } catch (EntityNotFoundException $e) {
            throw new HttpException($e->getMessage());
        }

        $data = [
            'points' => $zen
        ];

        $view = $this->view($data);

        return $this->handleView($view);
    }

}
