<?php
/**
 * @package    Zenomania\TransformerInterface
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */

namespace Zenomania\ApiBundle\Service\Transformer;

interface TransformerInterface
{
    public function getAvailableIncludes();

    public function getDefaultIncludes();
}