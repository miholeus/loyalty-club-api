<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 31.08.2017
 * Time: 12:34
 */

namespace Zenomania\CoreBundle\Entity;


class UserReferralActivation
{

    /** @var  */
    private $id;

    /** @var \DateTime */
    private $date;

    /** @var \Zenomania\CoreBundle\Entity\UserReferralCode */
    private $refCode;

    /** @var \Zenomania\CoreBundle\Entity\User */
    private $createdByUser;

    /** @var \Zenomania\CoreBundle\Entity\User */
    private $usedByUser;

    public function __construct()
    {
        $this->date = new \DateTime();
    }
    /**
     * @param array $data
     * @return UserReferralActivation
     */
    public static function fromArray(array $data) : UserReferralActivation
    {
        $self = new self();
        foreach ($data as $key => $value) {
            $self->{"set".ucfirst($key)}($value);
        }
        return $self;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * @return UserReferralCode
     */
    public function getRefCode(): UserReferralCode
    {
        return $this->refCode;
    }

    /**
     * @param UserReferralCode $refCode
     */
    public function setRefCode(UserReferralCode $refCode)
    {
        $this->refCode = $refCode;
        $this->createdByUser = $refCode->getUser();
    }

    /**
     * @return User
     */
    public function getCreatedByUser(): User
    {
        return $this->createdByUser;
    }

    /**
     * @param User $createdByUser
     */
    public function setCreatedByUser(User $createdByUser)
    {
        $this->createdByUser = $createdByUser;
    }

    /**
     * @return User
     */
    public function getUsedByUser(): User
    {
        return $this->usedByUser;
    }

    /**
     * @param User $usedByUser
     */
    public function setUsedByUser(User $usedByUser)
    {
        $this->usedByUser = $usedByUser;
    }
}