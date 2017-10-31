<?php

namespace Zenomania\CoreBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * ApiToken
 */
class ApiToken
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $token;

    /**
     * @var \DateTime
     */
    private $validTill;

    /**
     * @var bool
     */
    private $active = true;

    /**
     * @var \Zenomania\CoreBundle\Entity\User
     * @Assert\NotBlank()
     */
    private $user;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set token.
     *
     * @param string $token
     *
     * @return ApiToken
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token.
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set validTill.
     *
     * @param \DateTime $validTill
     *
     * @return ApiToken
     */
    public function setValidTill($validTill)
    {
        $this->validTill = $validTill;

        return $this;
    }

    /**
     * Get validTill.
     *
     * @return \DateTime
     */
    public function getValidTill()
    {
        return $this->validTill;
    }

    /**
     * Set active.
     *
     * @param bool $active
     *
     * @return ApiToken
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active.
     *
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set user.
     *
     * @param \Zenomania\CoreBundle\Entity\User $user
     *
     * @return ApiToken
     */
    public function setUser(\Zenomania\CoreBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \Zenomania\CoreBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
