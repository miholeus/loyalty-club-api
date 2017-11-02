<?php
/**
 * @package    Zenomania\ApiBundle\Service\Afr
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service\Afr;

interface TokenInterface
{
    /**
     * Gets user name
     *
     * @return mixed
     */
    public function getUsername();

    /**
     * Gets user credentials
     *
     * @return mixed
     */
    public function getCredentials();
}