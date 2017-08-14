<?php
/**
 * @package    Zenomania\ApiBundle\Service\Serializer
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */

namespace Zenomania\ApiBundle\Service\Serializer;

class ArraySerializer extends \League\Fractal\Serializer\ArraySerializer
{
    public function collection($resourceKey, array $data)
    {
        return $resourceKey ?: $data;
    }

}