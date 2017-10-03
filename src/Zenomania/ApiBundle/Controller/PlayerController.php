<?php
/**
 * @package    Zenomania\ApiBundle\Controller
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Zenomania\CoreBundle\Service\Player;

class PlayerController extends RestController
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
     *          "data":
     *          [
     *              {
     *                "first_name": <string>,
     *                "id": <integer>,
     *                "last_name": <string>,
     *                "middle_name": <string>,
     *                "photo": <string>
     *              }
     *          ]
     *          ,
     *          "time":<time request>
     *      }
     *
     * @ApiDoc(
     *  section="Прогнозы",
     *  resource=true,
     *  description="Получение списка игроков",
     *  statusCodes={
     *         204="При успешном запросе",
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
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getPlayersAction()
    {
        $service = $this->get('player.service');

        $players = $service->getActivePlayers(Player::DEFAULT_CLUB_ID);

        $transformer = $this->get('api.data.transformer.players');

        $dataEvent = $this->getResourceCollection($players, $transformer);

        $view = $this->view($dataEvent);
        return $this->handleView($view);
    }
}