<?php
/**
 * @package    Zenomania\ApiBundle\Controller
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class PointsController extends RestController
{
    /**
     *
     * ### Success Response ###
     *      {
     *          "data":{
     *              "ticket_registration": <integer>,
     *              "promo_code_registration": <integer>,
     *              "prediction": <integer>,
     *              "invite_friend": <integer>,
     *              "subscription_registration": <integer>
     *          },
     *          "time":<time request>
     *      }
     *
     * @ApiDoc(
     *  section="Бонусы",
     *  resource=true,
     *  description="Количество очков за различные действия",
     *  statusCodes={
     *         200="При успешном запросе"
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
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getPointsAction()
    {
        $points = $this->get('api.person_points');
        $data = $points->pointsForActions();

        $view = $this->view($data);
        return $this->handleView($view);
    }
}