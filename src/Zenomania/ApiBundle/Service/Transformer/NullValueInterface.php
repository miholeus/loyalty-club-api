<?php
/**
 * @package    Zenomania\ApiBundle\Service\Transformer
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */


namespace Zenomania\ApiBundle\Service\Transformer;

/**
 * Interface that helps to handle default values (usually, null values)
 */
interface NullValueInterface
{
    /**
     * Check if null value should be included into output
     *
     * @return bool
     */
    public function includeNull();
}