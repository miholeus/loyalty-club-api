<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * ClientApplication
 */
class ClientApplication
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $outerService;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $authKey;

    /**
     * @var string
     */
    private $url;

    /**
     * @var \Zenomania\CoreBundle\Entity\Club
     */
    private $clubOwner;


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
     * Set outerService
     *
     * @param string $outerService
     *
     * @return ClientApplication
     */
    public function setOuterService($outerService)
    {
        $this->outerService = $outerService;

        return $this;
    }

    /**
     * Get outerService
     *
     * @return string
     */
    public function getOuterService()
    {
        return $this->outerService;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return ClientApplication
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return ClientApplication
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set authKey
     *
     * @param string $authKey
     *
     * @return ClientApplication
     */
    public function setAuthKey($authKey)
    {
        $this->authKey = $authKey;

        return $this;
    }

    /**
     * Get authKey
     *
     * @return string
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return ClientApplication
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set clubOwner
     *
     * @param \Zenomania\CoreBundle\Entity\Club $clubOwner
     *
     * @return ClientApplication
     */
    public function setClubOwner(\Zenomania\CoreBundle\Entity\Club $clubOwner = null)
    {
        $this->clubOwner = $clubOwner;

        return $this;
    }

    /**
     * Get clubOwner
     *
     * @return \Zenomania\CoreBundle\Entity\Club
     */
    public function getClubOwner()
    {
        return $this->clubOwner;
    }
}

