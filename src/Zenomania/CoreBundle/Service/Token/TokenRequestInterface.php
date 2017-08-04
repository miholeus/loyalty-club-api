<?php
/**
 * @package    Zenomania\CoreBundle\Service\Token
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */

namespace Zenomania\CoreBundle\Service\Token;


interface TokenRequestInterface
{
    /**
     * Remembers token and sends registration request
     *
     * @param string $phone phone number to send key
     * @param string $token token saved in storage to identify user's requests
     * @return string key to register new user
     */
    public function makeRequest($phone, $token);
}
