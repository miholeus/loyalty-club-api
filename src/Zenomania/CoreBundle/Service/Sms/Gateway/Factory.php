<?php
/**
 * @package   Zenomania\CoreBundle/Service/Sms
 * @author    miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */
/**
 * @namespace
 */
namespace Zenomania\CoreBundle\Service\Sms\Gateway;

/**
 * Create Gateway objects
 */

class Factory
{
    /**
     * Create gateway
     *
     * @param $class
     * @return AbstractGateway
     */
    public static function factory($class)
    {
        return new $class;
    }
}
