<?php
/**
 * @package    Zenomania\ApiBundle\Service\Transformer\Event
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service\Transformer\Event;

use Zenomania\ApiBundle\Service\Transformer\PlayerTransformer;
use Zenomania\CoreBundle\Entity\Event;
use Zenomania\CoreBundle\Entity\EventPlayerForecast;

class LineUpMvpForecastTransformer extends LineUpForecastTransformer
{
    public function transform(Event $event)
    {
        $user = $this->getUser();
        /** @var EventPlayerForecast $forecast */
        $forecast = $this->getRepository()->findOneBy(['event' => $event, 'user' => $user, 'isMvp' => true]);
        if (null !== $forecast) {
            return $this->item($forecast->getPlayer(), new PlayerTransformer($this->url));
        }
        return null;
    }
}