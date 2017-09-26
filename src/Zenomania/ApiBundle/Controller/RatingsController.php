<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 25.09.17
 * Time: 15:29
 */

namespace Zenomania\ApiBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Symfony\Component\HttpFoundation\Request;
use Zenomania\ApiBundle\Form\RatingsType;

class RatingsController extends RestController
{
    /**
     * @QueryParam(name="limit", default="20", requirements="\d+", description="Количество запрашиваемых записей" )
     * @QueryParam(name="offset", nullable=true, requirements="\d+", description="Смещение, с которого нужно начать просмотр")
     * @QueryParam(name="period", description="За какой период сделать выборку месяц(month)|сезон(season)|за все время()")
     *
     * @Route("ratings")
     */
    public function getRatingsAction(Request $request)
    {
        $form = $this->createForm(RatingsType::class);
        $this->processForm($request, $form);
        if (!$form->isValid()) {
            throw $this->createFormValidationException($form);
        }

        $ratingsService = $this->get('api.ratings');
        $ratingsService->getRatings($form->getData());
    }
}