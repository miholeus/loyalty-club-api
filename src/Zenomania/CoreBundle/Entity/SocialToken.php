<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * SocialToken
 */
class SocialToken
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $network;

    /**
     * @var string
     */
    private $userOuterId = '';

    /**
     * @var string
     */
    private $token = '';

    /**
     * @var string
     */
    private $permissions = '';

    /**
     * @var string
     */
    private $secret;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set network
     *
     * @param string $network
     *
     * @return SocialToken
     */
    public function setNetwork($network)
    {
        $this->network = $network;

        return $this;
    }

    /**
     * Get network
     *
     * @return string
     */
    public function getNetwork()
    {
        return $this->network;
    }

    /**
     * Set userOuterId
     *
     * @param string $userOuterId
     *
     * @return SocialToken
     */
    public function setUserOuterId($userOuterId)
    {
        $this->userOuterId = $userOuterId;

        return $this;
    }

    /**
     * Get userOuterId
     *
     * @return string
     */
    public function getUserOuterId()
    {
        return $this->userOuterId;
    }

    /**
     * Set token
     *
     * @param string $token
     *
     * @return SocialToken
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set permissions
     *
     * @param string $permissions
     *
     * @return SocialToken
     */
    public function setPermissions($permissions)
    {
        $this->permissions = $permissions;

        return $this;
    }

    /**
     * Get permissions
     *
     * @return string
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * Set secret
     *
     * @param string $secret
     *
     * @return SocialToken
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;

        return $this;
    }

    /**
     * Get secret
     *
     * @return string
     */
    public function getSecret()
    {
        return $this->secret;
    }
}
