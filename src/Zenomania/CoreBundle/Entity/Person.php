<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * Person
 */
class Person
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $promoCode;

    /**
     * @var string
     */
    private $avatar;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $middleName;

    /**
     * @var string
     */
    private $sex;

    /**
     * @var string
     */
    private $familystatus;

    /**
     * @var \DateTime
     */
    private $bdate;

    /**
     * @var string
     */
    private $comesBy;

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $mobile;

    /**
     * @var string
     */
    private $mobileAvailable;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $mobileAdd;

    /**
     * @var string
     */
    private $emailAdd;

    /**
     * @var string
     */
    private $notes;

    /**
     * @var boolean
     */
    private $emailAllowed = '1';

    /**
     * @var boolean
     */
    private $smsAllowed = '1';

    /**
     * @var \DateTime
     */
    private $regDate;

    /**
     * @var integer
     */
    private $regActor;

    /**
     * @var string
     */
    private $regType = 'other';

    /**
     * @var string
     */
    private $regTypeName;

    /**
     * @var boolean
     */
    private $emailConfirmed = '0';

    /**
     * @var \Zenomania\CoreBundle\Entity\City
     */
    private $city;

    /**
     * @var \Zenomania\CoreBundle\Entity\Club
     */
    private $clubOwner;

    /**
     * @var \Zenomania\CoreBundle\Entity\District
     */
    private $district;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $fancard;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $activity;

    /**
     * @var \Zenomania\CoreBundle\Entity\User
     */
    private $user;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fancard = new \Doctrine\Common\Collections\ArrayCollection();
        $this->activity = new \Doctrine\Common\Collections\ArrayCollection();
        $this->regDate = new \DateTime();
    }

    /**
     * Set data from array
     *
     * @param array $data
     * @return Person
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
     * Sets data from array
     *
     * @param array $data
     */
    public function setFromArray(array $data)
    {
        foreach ($data as $key => $value) {
            $this->{"set" . ucfirst($key)}($value);
        }
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
     * Set promoCode
     *
     * @param string $promoCode
     *
     * @return Person
     */
    public function setPromoCode($promoCode)
    {
        $this->promoCode = $promoCode;

        return $this;
    }

    /**
     * Get promoCode
     *
     * @return string
     */
    public function getPromoCode()
    {
        return $this->promoCode;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     *
     * @return Person
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Person
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Person
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set middleName
     *
     * @param string $middleName
     *
     * @return Person
     */
    public function setMiddleName($middleName)
    {
        $this->middleName = $middleName;

        return $this;
    }

    /**
     * Get middleName
     *
     * @return string
     */
    public function getMiddleName()
    {
        return $this->middleName;
    }

    /**
     * Set sex
     *
     * @param string $sex
     *
     * @return Person
     */
    public function setSex($sex)
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * Get sex
     *
     * @return string
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * Set familystatus
     *
     * @param string $familystatus
     *
     * @return Person
     */
    public function setFamilystatus($familystatus)
    {
        $this->familystatus = $familystatus;

        return $this;
    }

    /**
     * Get familystatus
     *
     * @return string
     */
    public function getFamilystatus()
    {
        return $this->familystatus;
    }

    /**
     * Set bdate
     *
     * @param \DateTime $bdate
     *
     * @return Person
     */
    public function setBdate($bdate)
    {
        $this->bdate = $bdate;

        return $this;
    }

    /**
     * Get bdate
     *
     * @return \DateTime
     */
    public function getBdate()
    {
        return $this->bdate;
    }

    /**
     * Set comesBy
     *
     * @param string $comesBy
     *
     * @return Person
     */
    public function setComesBy($comesBy)
    {
        $this->comesBy = $comesBy;

        return $this;
    }

    /**
     * Get comesBy
     *
     * @return string
     */
    public function getComesBy()
    {
        return $this->comesBy;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Person
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set mobile
     *
     * @param string $mobile
     *
     * @return Person
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Get mobile
     *
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set mobileAvailable
     *
     * @param string $mobileAvailable
     *
     * @return Person
     */
    public function setMobileAvailable($mobileAvailable)
    {
        $this->mobileAvailable = $mobileAvailable;

        return $this;
    }

    /**
     * Get mobileAvailable
     *
     * @return string
     */
    public function getMobileAvailable()
    {
        return $this->mobileAvailable;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Person
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set mobileAdd
     *
     * @param string $mobileAdd
     *
     * @return Person
     */
    public function setMobileAdd($mobileAdd)
    {
        $this->mobileAdd = $mobileAdd;

        return $this;
    }

    /**
     * Get mobileAdd
     *
     * @return string
     */
    public function getMobileAdd()
    {
        return $this->mobileAdd;
    }

    /**
     * Set emailAdd
     *
     * @param string $emailAdd
     *
     * @return Person
     */
    public function setEmailAdd($emailAdd)
    {
        $this->emailAdd = $emailAdd;

        return $this;
    }

    /**
     * Get emailAdd
     *
     * @return string
     */
    public function getEmailAdd()
    {
        return $this->emailAdd;
    }

    /**
     * Set notes
     *
     * @param string $notes
     *
     * @return Person
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set emailAllowed
     *
     * @param boolean $emailAllowed
     *
     * @return Person
     */
    public function setEmailAllowed($emailAllowed)
    {
        $this->emailAllowed = $emailAllowed;

        return $this;
    }

    /**
     * Get emailAllowed
     *
     * @return boolean
     */
    public function getEmailAllowed()
    {
        return $this->emailAllowed;
    }

    /**
     * Set smsAllowed
     *
     * @param boolean $smsAllowed
     *
     * @return Person
     */
    public function setSmsAllowed($smsAllowed)
    {
        $this->smsAllowed = $smsAllowed;

        return $this;
    }

    /**
     * Get smsAllowed
     *
     * @return boolean
     */
    public function getSmsAllowed()
    {
        return $this->smsAllowed;
    }

    /**
     * Set regDate
     *
     * @param \DateTime $regDate
     *
     * @return Person
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
     * Set regActor
     *
     * @param integer $regActor
     *
     * @return Person
     */
    public function setRegActor($regActor)
    {
        $this->regActor = $regActor;

        return $this;
    }

    /**
     * Get regActor
     *
     * @return integer
     */
    public function getRegActor()
    {
        return $this->regActor;
    }

    /**
     * Set regType
     *
     * @param string $regType
     *
     * @return Person
     */
    public function setRegType($regType)
    {
        $this->regType = $regType;

        return $this;
    }

    /**
     * Get regType
     *
     * @return string
     */
    public function getRegType()
    {
        return $this->regType;
    }

    /**
     * Set regTypeName
     *
     * @param string $regTypeName
     *
     * @return Person
     */
    public function setRegTypeName($regTypeName)
    {
        $this->regTypeName = $regTypeName;

        return $this;
    }

    /**
     * Get regTypeName
     *
     * @return string
     */
    public function getRegTypeName()
    {
        return $this->regTypeName;
    }

    /**
     * Set emailConfirmed
     *
     * @param boolean $emailConfirmed
     *
     * @return Person
     */
    public function setEmailConfirmed($emailConfirmed)
    {
        $this->emailConfirmed = $emailConfirmed;

        return $this;
    }

    /**
     * Get emailConfirmed
     *
     * @return boolean
     */
    public function getEmailConfirmed()
    {
        return $this->emailConfirmed;
    }

    /**
     * Set city
     *
     * @param \Zenomania\CoreBundle\Entity\City $city
     *
     * @return Person
     */
    public function setCity(\Zenomania\CoreBundle\Entity\City $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \Zenomania\CoreBundle\Entity\City
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set clubOwner
     *
     * @param \Zenomania\CoreBundle\Entity\Club $clubOwner
     *
     * @return Person
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
     * Set district
     *
     * @param \Zenomania\CoreBundle\Entity\District $district
     *
     * @return Person
     */
    public function setDistrict(\Zenomania\CoreBundle\Entity\District $district = null)
    {
        $this->district = $district;

        return $this;
    }

    /**
     * Get district
     *
     * @return \Zenomania\CoreBundle\Entity\District
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * Add fancard
     *
     * @param \Zenomania\CoreBundle\Entity\FanCard $fancard
     *
     * @return Person
     */
    public function addFancard(\Zenomania\CoreBundle\Entity\FanCard $fancard)
    {
        $this->fancard[] = $fancard;

        return $this;
    }

    /**
     * Remove fancard
     *
     * @param \Zenomania\CoreBundle\Entity\FanCard $fancard
     */
    public function removeFancard(\Zenomania\CoreBundle\Entity\FanCard $fancard)
    {
        $this->fancard->removeElement($fancard);
    }

    /**
     * Get fancard
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFancard()
    {
        return $this->fancard;
    }

    /**
     * Add activity
     *
     * @param \Zenomania\CoreBundle\Entity\Activity $activity
     *
     * @return Person
     */
    public function addActivity(\Zenomania\CoreBundle\Entity\Activity $activity)
    {
        $this->activity[] = $activity;

        return $this;
    }

    /**
     * Remove activity
     *
     * @param \Zenomania\CoreBundle\Entity\Activity $activity
     */
    public function removeActivity(\Zenomania\CoreBundle\Entity\Activity $activity)
    {
        $this->activity->removeElement($activity);
    }

    /**
     * Get activity
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActivity()
    {
        return $this->activity;
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
    public function setUser($user)
    {
        $this->user = $user;
    }
}
