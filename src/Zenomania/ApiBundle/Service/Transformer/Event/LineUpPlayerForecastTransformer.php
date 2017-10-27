<?php
/**
 * @package    Zenomania\ApiBundle\Service\Transformer\Event
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service\Transformer\Event;

use Zenomania\ApiBundle\Service\Transformer\PlayerTransformer;
use Zenomania\ApiBundle\Service\Transformer\TransformerAbstract;
use Zenomania\CoreBundle\Entity\EventPlayerForecast;
use Zenomania\CoreBundle\Service\Utils\HostBasedUrl;

class LineUpPlayerForecastTransformer extends TransformerAbstract
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