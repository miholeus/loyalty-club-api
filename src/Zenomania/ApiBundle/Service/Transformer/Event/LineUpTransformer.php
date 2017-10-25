<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 25.10.2017
 * Time: 11:08
 */

namespace Zenomania\ApiBundle\Service\Transformer\Event;


use Zenomania\ApiBundle\Service\Transformer\PlayerTransformer;
use Zenomania\ApiBundle\Service\Transformer\TransformerAbstract;
use Zenomania\CoreBundle\Entity\LineUp;
use Zenomania\CoreBundle\Service\Utils\HostBasedUrl;

class LineUpTransformer extends TransformerAbstract
{
    /**
     * @var HostBasedUrl
     */
    private $url;

    public function __construct(HostBasedUrl $url)
    {
        $this->url = $url;
    }

    public function transform(LineUp $lineUp)
    {
        return [
            'id' => $lineUp->getPlayer()->getId(),
            'first_name' => $lineUp->getPlayer()->getFirstname(),
            'last_name' => $lineUp->getPlayer()->getLastname(),
            'middle_name' => $lineUp->getPlayer()->getMiddlename(),
            'photo' => $this->url->getUrl($lineUp->getPlayer()->getPhoto())
        ];
    }
}