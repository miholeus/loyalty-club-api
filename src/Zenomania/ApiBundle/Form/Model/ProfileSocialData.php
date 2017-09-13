<?php

namespace Zenomania\ApiBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

class ProfileSocialData
{
    /**
     * @Assert\NotBlank()
     * @var string
     */
    private $accessToken;

    /**
     * @Assert\NotBlank()
     * @var integer
     */
    private $userId;

    /**
     * @Assert\NotBlank()
     * @var string
     */
    private $email;

    /**
     * @var integer
     */
    private $expiresIn;

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * @param string $accessToken
     */
    public function setAccessToken(string $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param integer $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return integer
     */
    public function getExpiresIn()
    {
        return $this->expiresIn;
    }

    /**
     * @param integer $expiresIn
     */
    public function setExpiresIn($expiresIn)
    {
        $this->expiresIn = $expiresIn;
    }

    /**
     * @param array $data
     * @return ProfileSocialData
     */
    public static function fromArray(array $data): ProfileSocialData
    {
        $self = new self();
        foreach ($data as $key => $value) {
            $self->{"set".ucfirst($key)}($value);
        }
        return $self;
    }
}