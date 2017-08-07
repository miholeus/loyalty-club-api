<?php
/**
 * @package    Zenomania\CoreBundle\Form\Model
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */

namespace Zenomania\CoreBundle\Form\Model;

interface TokenInterface
{
    /**
     * Get token
     *
     * @return mixed
     */
    public function getToken();

    /**
     * Set token
     *
     * @param mixed $token
     * @return mixed
     */
    public function setToken($token);
}