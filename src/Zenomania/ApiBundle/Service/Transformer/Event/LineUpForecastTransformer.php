<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 25.10.2017
 * Time: 13:04
 */

namespace Zenomania\ApiBundle\Service\Transformer\Event;

use Zenomania\ApiBundle\Service\Transformer\PlayerTransformer;
use Zenomania\ApiBundle\Service\Transformer\TransformerAbstract;
use Zenomania\CoreBundle\Entity\EventPlayerForecast;
use Zenomania\CoreBundle\Service\Utils\HostBasedUrl;

class LineUpForecastTransformer extends TransformerAbstract
{
    /**
     * @var HostBasedUrl
     */
    private $url;

    public function __construct(HostBasedUrl $url)
    {
        $this->url = $url;
    }

    public function transform(EventPlayerForecast $playerForecast)
    {
        return $this->item($playerForecast->getPlayer(), new PlayerTransformer($this->url));
    }
}