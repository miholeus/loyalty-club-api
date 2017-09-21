<?php
/**
 * @package    Zenomania\ApiBundle\Service\Transformer
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service\Transformer;

use Zenomania\CoreBundle\Entity\Club;
use Zenomania\CoreBundle\Service\Utils\HostBasedUrl;

class ClubTransformer extends TransformerAbstract
{
    /**
     * @var HostBasedUrl
     */
    private $url;

    public function __construct(HostBasedUrl $url)
    {
        $this->url = $url;
    }

    public function transform(Club $club)
    {
        return [
            'id' => $club->getId(),
            'name' => $club->getName(),
            'logo' => $this->url->getUrl($club->getLogoImg())
        ];
    }
}