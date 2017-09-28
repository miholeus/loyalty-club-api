<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 15.09.2017
 * Time: 15:37
 */

namespace Zenomania\CoreBundle\Entity;


class DeviceToken
{

    /** @var integer */
    private $id;

    /** @var string */
    private $token;

    /** @var \DateTime */
    private $createdOn;

    /** @var \DateTime */
    private $updatedOn;

    /** @var string */
    private $deviceType;

    /** @var string */
    private $deviceName;

    /** @var integer */
    private $status;

    /** @var User */
    private $user;

    public function __construct()
    {
        $this->createdOn = new \DateTime();
        $this->updatedOn = new \DateTime();
    }

    /**
     * @param array $data
     * @return DeviceToken
     */
    public static function fromArray(array $data)
    {
        $self = new self();
        foreach ($data as $key => $value) {
            $self->{"set" . ucfirst($key)}($value);
        }

        return $self;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return DeviceToken
     */
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     *
     * @return DeviceToken
     */
    public function setToken(string $token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @param \DateTime $createdOn
     *
     * @return DeviceToken
     */
    public function setCreatedOn(\DateTime $createdOn)
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }

    /**
     * @param \DateTime $updatedOn
     *
     * @return DeviceToken
     */
    public function setUpdatedOn(\DateTime $updatedOn)
    {
        $this->updatedOn = $updatedOn;

        return $this;
    }

    /**
     * @return string
     */
    public function getDeviceType()
    {
        return $this->deviceType;
    }

    /**
     * @param string $deviceType
     *
     * @return DeviceToken
     */
    public function setDeviceType(string $deviceType)
    {
        $this->deviceType = $deviceType;

        return $this;
    }

    /**
     * @return string
     */
    public function getDeviceName()
    {
        return $this->deviceName;
    }

    /**
     * @param string $deviceName
     *
     * @return DeviceToken
     */
    public function setDeviceName(string $deviceName)
    {
        $this->deviceName = $deviceName;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     *
     * @return DeviceToken
     */
    public function setStatus(int $status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }
}
