<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * Actor
 */
class Actor
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $token;

    /**
     * @var integer
     */
    private $refrr;

    /**
     * @var boolean
     */
    private $shouldChangePwd = '0';

    /**
     * @var string
     */
    private $authToken;

    /**
     * @var string
     */
    private $vkId;

    /**
     * @var string
     */
    private $fbId;

    /**
     * @var string
     */
    private $resetToken;

    /**
     * @var \DateTime
     */
    private $regDate;

    /**
     * @var string
     */
    private $regSource;

    /**
     * @var \Zenomania\CoreBundle\Entity\Club
     */
    private $clubOwner;

    /**
     * @var \Zenomania\CoreBundle\Entity\Person
     */
    private $person;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $roles;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
    }
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
     * Set username
     *
     * @param string $username
     *
     * @return Actor
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Actor
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
     * Set token
     *
     * @param string $token
     *
     * @return Actor
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
     * Set refrr
     *
     * @param integer $refrr
     *
     * @return Actor
     */
    public function setRefrr($refrr)
    {
        $this->refrr = $refrr;

        return $this;
    }

    /**
     * Get refrr
     *
     * @return integer
     */
    public function getRefrr()
    {
        return $this->refrr;
    }

    /**
     * Set shouldChangePwd
     *
     * @param boolean $shouldChangePwd
     *
     * @return Actor
     */
    public function setShouldChangePwd($shouldChangePwd)
    {
        $this->shouldChangePwd = $shouldChangePwd;

        return $this;
    }

    /**
     * Get shouldChangePwd
     *
     * @return boolean
     */
    public function getShouldChangePwd()
    {
        return $this->shouldChangePwd;
    }

    /**
     * Set authToken
     *
     * @param string $authToken
     *
     * @return Actor
     */
    public function setAuthToken($authToken)
    {
        $this->authToken = $authToken;

        return $this;
    }

    /**
     * Get authToken
     *
     * @return string
     */
    public function getAuthToken()
    {
        return $this->authToken;
    }

    /**
     * Set vkId
     *
     * @param string $vkId
     *
     * @return Actor
     */
    public function setVkId($vkId)
    {
        $this->vkId = $vkId;

        return $this;
    }

    /**
     * Get vkId
     *
     * @return string
     */
    public function getVkId()
    {
        return $this->vkId;
    }

    /**
     * Set fbId
     *
     * @param string $fbId
     *
     * @return Actor
     */
    public function setFbId($fbId)
    {
        $this->fbId = $fbId;

        return $this;
    }

    /**
     * Get fbId
     *
     * @return string
     */
    public function getFbId()
    {
        return $this->fbId;
    }

    /**
     * Set resetToken
     *
     * @param string $resetToken
     *
     * @return Actor
     */
    public function setResetToken($resetToken)
    {
        $this->resetToken = $resetToken;

        return $this;
    }

    /**
     * Get resetToken
     *
     * @return string
     */
    public function getResetToken()
    {
        return $this->resetToken;
    }

    /**
     * Set regDate
     *
     * @param \DateTime $regDate
     *
     * @return Actor
     */
    public function setRegDate($regDate)
    {
        $this->regDate = $regDate;

        return $this;
    }

    /**
     * Get regDate
     *
     * @return \DateTime
     */
    public function getRegDate()
    {
        return $this->regDate;
    }

    /**
     * Set regSource
     *
     * @param string $regSource
     *
     * @return Actor
     */
    public function setRegSource($regSource)
    {
        $this->regSource = $regSource;

        return $this;
    }

    /**
     * Get regSource
     *
     * @return string
     */
    public function getRegSource()
    {
        return $this->regSource;
    }

    /**
     * Set clubOwner
     *
     * @param \Zenomania\CoreBundle\Entity\Club $clubOwner
     *
     * @return Actor
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

    /**
     * Set person
     *
     * @param \Zenomania\CoreBundle\Entity\Person $person
     *
     * @return Actor
     */
    public function setPerson(\Zenomania\CoreBundle\Entity\Person $person = null)
    {
        $this->person = $person;

        return $this;
    }

    /**
     * Get person
     *
     * @return \Zenomania\CoreBundle\Entity\Person
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * Add role
     *
     * @param \Zenomania\CoreBundle\Entity\Role $role
     *
     * @return Actor
     */
    public function addRole(\Zenomania\CoreBundle\Entity\Role $role)
    {
        $this->roles[] = $role;

        return $this;
    }

    /**
     * Remove role
     *
     * @param \Zenomania\CoreBundle\Entity\Role $role
     */
    public function removeRole(\Zenomania\CoreBundle\Entity\Role $role)
    {
        $this->roles->removeElement($role);
    }

    /**
     * Get roles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRoles()
    {
        return $this->roles;
    }
}
