<?php
/**
 * @package    Zenomania\ApiBundle\Service\Transformer
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */

namespace Zenomania\ApiBundle\Service\Transformer;


/**
 * Abstract transformer with help methods to handle data
 */
abstract class TransformerAbstract extends \League\Fractal\TransformerAbstract
    implements TransformerInterface, NullValueInterface
{
    /**
     * Defines if null is included in transformation
     *
     * @var bool
     */
    protected $includeNull = true;
    /**
     * Gets default value if no value is present
     *
     * @var null
     */
    protected $defaultValue = null;

    public function formatTimestamp(\DateTime $dateTime = null)
    {
        if ($dateTime) {
            return $dateTime->getTimestamp();
        }
        return $this->getDefaultValue();
    }

    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    public function includeNull()
    {
        return $this->includeNull;
    }
}