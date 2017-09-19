<?php
/**
 * @package    Zenomania\ApiBundle\Service\Transformer
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service\Transformer;

use Zenomania\CoreBundle\Entity\Club;

class ClubTransformer extends TransformerAbstract
{
    public function transform(Club $club)
    {
        return [
            'id' => $club->getId()
        ];
    }
}