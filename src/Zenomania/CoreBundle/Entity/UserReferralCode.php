<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 29.08.2017
 * Time: 17:15
 */

namespace Zenomania\CoreBundle\Entity;

class UserReferralCode
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $refCode;

    /**
     * @var boolean
     */
    private $activated;

    /**
     * @var integer
     */
    private $activations;

    /**
     * @var \DateTime
     */
    private $dateCreated;

    /**
     * @var \DateTime
     */
    private $dateUpdated;

    /**
     * @var \Zenomania\CoreBundle\Entity\User
     */
    private $user;

    public function __construct()
    {
        $this->activations = 0;
        $this->activated = false;
        $this->dateCreated = new \DateTime();
        $this->dateUpdated = new \DateTime();
    }
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getRefCode(): string
    {
        return $this->refCode;
    }

    /**
     * @param string $refCode
     */
    public function setRefCode(string $refCode)
    {
        $this->refCode = $refCode;
    }

    /**
     * @return int
     */
    public function getActivations(): int
    {
        return $this->activations;
    }

    /**
     * @param int $activations
     */
    public function setActivations(int $activations)
    {
        $this->activations = $activations;
    }

    /**
     * @return bool
     */
    public function isActivated(): bool
    {
        return $this->activated;
    }

    /**
     * @param bool $activated
     */
    public function setActivated(bool $activated)
    {
        $this->activated = $activated;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreated(): \DateTime
    {
        return $this->dateCreated;
    }

    /**
     * @param \DateTime $dateCreated
     */
    public function setDateCreated(\DateTime $dateCreated)
    {
        $this->dateCreated = $dateCreated;
    }

    /**
     * @return \DateTime
     */
    public function getDateUpdated(): \DateTime
    {
        return $this->dateUpdated;
    }

    /**
     * @param \DateTime $dateUpdated
     */
    public function setDateUpdated(\DateTime $dateUpdated)
    {
        $this->dateUpdated = $dateUpdated;
    }

    /**
     * @return User
     */
    public function getUser(): User
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

    /**
     * @param array $data
     * @return UserReferralCode
     */
    public static function fromArray(array $data) : UserReferralCode
    {
        $self = new self();
        foreach ($data as $key => $value) {
            $self->{"set".ucfirst($key)}($value);
        }
        return $self;
    }

    /**
     * Adds activation
     */
    public function addActivation()
    {
        $this->activations++;
        $this->activated = true;
    }
}
