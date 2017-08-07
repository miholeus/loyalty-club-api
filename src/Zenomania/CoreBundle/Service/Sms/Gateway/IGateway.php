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

use Zenomania\CoreBundle\Service\Sms;
/**
 * Gateway Interface
 */
interface IGateway
{
    /**
     * Gateway name
     *
     * @return mixed
     */
    public function getName();
    /**
     * Send sms
     *
     * @param Sms\Message $message
     * @return mixed
     */
    public function send(Sms\Message $message);
}
