<?php
/**
 * @package    Zenomania\ApiBundle\Service\Transformer
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service\Transformer;

use Zenomania\CoreBundle\Entity\Player;
use Zenomania\CoreBundle\Service\Utils\HostBasedUrl;

class PlayerTransformer extends TransformerAbstract
{
    /**
     * @var HostBasedUrl
     */
    private $url;

    public function __construct(HostBasedUrl $url)
    {
        $this->url = $url;
    }

    /**
     * Transforms player
     *
     * @param Player $player
     * @return array
     */
    public function transform(Player $player)
    {
        return [
            'id' => $player->getId(),
            'firstname' => $player->getFirstname(),
            'lastname' => $player->getLastname(),
            'middlename' => $player->getMiddlename(),
            'photo' => $this->url->getUrl($player->getPhoto())
        ];
    }
}