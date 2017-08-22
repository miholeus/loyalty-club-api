<?php

namespace Zenomania\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Zenomania\CoreBundle\Entity\Validator\Constraints\ContainsDateBirthday;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Zenomania\CoreBundle\Service\Upload\IdentifiableInterface;

/**
 * Users
 *
 * @ORM\Table(name="users", uniqueConstraints={@ORM\UniqueConstraint(name="email__idx", columns={"email"})}, indexes={@ORM\Index(name="role_id__idx", columns={"role_id"}), @ORM\Index(name="status_id__idx", columns={"status_id"}), @ORM\Index(name="login_credenitials__idx", columns={"login", "password"})})
 * @ORM\Entity
 * @UniqueEntity(
 *     fields = {"email"},
 *     errorPath = "email",
 *     message = "This email is already in use"
 * )
 * @UniqueEntity(
 *     fields = {"phone"},
 *     errorPath = "phone",
 *     message = "This phone is already in use"
 * )
 * @UniqueEntity(
 *     fields = {"login"},
 *     errorPath = "login",
 *     message = "This login is already in use"
 * )
 */
class User implements UserInterface, \Serializable, AdvancedUserInterface, IdentifiableInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="users_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;
    /**
     * User roles
     *
     * @var array
     */
    private $roles = [];

    public function getEntityIdentifier()
    {
        return $this->getId();
    }

    public function isAccountNonExpired()
    {
        return !$this->isDeleted;
    }

    public function isAccountNonLocked()
    {
        return !$this->isBlocked;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->isActive;
    }

    public function getEntityName()
    {
        return strtolower((new \ReflectionClass($this))->getShortName());
    }

    public function propertiesVisibleInChangeSet()
    {

    }

    public function propertiesNotVisibleInChangeSet()
    {
        return [
            'password'
        ];
    }

    public function serialize()
    {
        return serialize([
            $this->id,
            $this->login,
            $this->password,
            $this->roles,
            $this->isActive
        ]);
    }

    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->login,
            $this->password,
            $this->roles,
            $this->isActive
            ) = unserialize($serialized);
    }

    public function getRoles()
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }

    /**
     * Add user role
     *
     * @param $role
     */
    public function addRole($role)
    {
        $this->roles[] = $role;
    }

    public function getUsername()
    {
        return $this->login;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function __construct(array $data = array())
    {
        if (!empty($data)) {
            $this->setFromArray($data);
        }
    }

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=50)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=50)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="middlename", type="string", length=255, nullable=true)
     * @Assert\Length(max=50)
     */
    private $middlename;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     * @Assert\NotBlank(groups={"registration"})
     */
    private $password;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birth_date", type="date", nullable=true)
     * @ContainsDateBirthday
     */
    private $birthDate;

    /**
     * @var string
     *
     * @ORM\Column(name="avatar", type="string", length=255, nullable=true)
     * @Assert\File(mimeTypes={ "image/jpg", "image/jpeg", "image/png" }, groups={"upload"})
     * @Assert\Image(
     *    mimeTypesMessage = "Неверный формат картинки",
     *    maxSize = "5M",
     *    maxSizeMessage = "Картинка слишком большого размера",
     *    groups={"upload"}
     * )
     */
    private $avatar;

    /**
     * @var string
     *
     * @ORM\Column(name="avatar_small", type="string", length=255, nullable=true)
     * @Assert\File(mimeTypes={ "image/jpg", "image/jpeg", "image/png" }, groups={"upload"})
     * @Assert\Image(
     *    mimeTypesMessage = "Неверный формат картинки",
     *    maxSize = "5M",
     *    maxSizeMessage = "Картинка слишком большого размера",
     *    groups={"upload"}
     * )
     */
    private $avatarSmall;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_login_on", type="datetime", nullable=true)
     */
    private $lastLoginOn;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_on", type="datetime", nullable=true)
     */
    private $createdOn;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_on", type="datetime", nullable=true)
     */
    private $updatedOn;

    /**
     * @var boolean
     *
     * @ORM\Column(name="mail_notification", type="boolean", nullable=true)
     */
    private $mailNotification;

    /**
     * @var boolean
     *
     * @ORM\Column(name="must_change_passwd", type="boolean", nullable=true)
     */
    private $mustChangePasswd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="passwd_changed_on", type="datetime", nullable=true)
     */
    private $passwdChangedOn;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=true)
     */
    private $isActive;

    /**
     * @var string
     *
     * @ORM\Column(name="verify_email_uuid", type="string", length=50, nullable=true)
     */
    private $verifyEmailUuid;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_superuser", type="boolean", nullable=true)
     */
    private $isSuperuser;

    /**
     * @var \Zenomania\CoreBundle\Entity\UserStatus
     * @Assert\NotBlank()
     *
     * @ORM\ManyToOne(targetEntity="Zenomania\CoreBundle\Entity\UserStatus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     * })
     */
    private $status;

    /**
     * @var \Zenomania\CoreBundle\Entity\UserRole
     * @Assert\NotBlank()
     *
     * @ORM\ManyToOne(targetEntity="Zenomania\CoreBundle\Entity\UserRole")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     * })
     */
    private $role;

    /**
     * @var \Zenomania\CoreBundle\Entity\Person
     */
    private $person;

    /**
     * @var string
     * @Assert\Regex("/^[0-9]{11}$/")
     * @Assert\NotBlank()
     */
    private $phone;

    /**
     * @var boolean
     */
    private $isBlocked = false;

    /**
     * @var boolean
     */
    private $isDeleted = false;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function __toString()
    {
        return sprintf("%s %s", $this->getFirstname(), $this->getLastname());
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set middlename
     *
     * @param string $middlename
     * @return User
     */
    public function setMiddlename($middlename)
    {
        $this->middlename = $middlename;

        return $this;
    }

    /**
     * Get middlename
     *
     * @return string
     */
    public function getMiddlename()
    {
        return $this->middlename;
    }

    /**
     * Set login
     *
     * @param string $login
     * @return User
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
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
     * Set password
     *
     * @param string $password
     * @return User
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
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        // no salt used
    }

    /**
     * Set birthDate
     *
     * @param \DateTime $birthDate
     * @return User
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     * @return User
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
     * Set avatarSmall
     *
     * @param string $avatarSmall
     * @return User
     */
    public function setAvatarSmall($avatarSmall)
    {
        $this->avatarSmall = $avatarSmall;

        return $this;
    }

    /**
     * Get avatarSmall
     *
     * @return string
     */
    public function getAvatarSmall()
    {
        return $this->avatarSmall;
    }

    /**
     * Set lastLoginOn
     *
     * @param \DateTime $lastLoginOn
     * @return User
     */
    public function setLastLoginOn($lastLoginOn)
    {
        $this->lastLoginOn = $lastLoginOn;

        return $this;
    }

    /**
     * Get lastLoginOn
     *
     * @return \DateTime
     */
    public function getLastLoginOn()
    {
        return $this->lastLoginOn;
    }

    /**
     * Set createdOn
     *
     * @param \DateTime $createdOn
     * @return User
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    /**
     * Get createdOn
     *
     * @return \DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * Set updatedOn
     *
     * @param \DateTime $updatedOn
     * @return User
     */
    public function setUpdatedOn($updatedOn)
    {
        $this->updatedOn = $updatedOn;

        return $this;
    }

    /**
     * Get updatedOn
     *
     * @return \DateTime
     */
    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }

    /**
     * Set mailNotification
     *
     * @param boolean $mailNotification
     * @return User
     */
    public function setMailNotification($mailNotification)
    {
        $this->mailNotification = $mailNotification;

        return $this;
    }

    /**
     * Get mailNotification
     *
     * @return boolean
     */
    public function getMailNotification()
    {
        return $this->mailNotification;
    }

    /**
     * Set mustChangePasswd
     *
     * @param boolean $mustChangePasswd
     * @return User
     */
    public function setMustChangePasswd($mustChangePasswd)
    {
        $this->mustChangePasswd = $mustChangePasswd;

        return $this;
    }

    /**
     * Get mustChangePasswd
     *
     * @return boolean
     */
    public function getMustChangePasswd()
    {
        return $this->mustChangePasswd;
    }

    /**
     * Set passwdChangedOn
     *
     * @param \DateTime $passwdChangedOn
     * @return User
     */
    public function setPasswdChangedOn($passwdChangedOn)
    {
        $this->passwdChangedOn = $passwdChangedOn;

        return $this;
    }

    /**
     * Get passwdChangedOn
     *
     * @return \DateTime
     */
    public function getPasswdChangedOn()
    {
        return $this->passwdChangedOn;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set verifyEmailUuid
     *
     * @param string $verifyEmailUuid
     * @return User
     */
    public function setVerifyEmailUuid($verifyEmailUuid)
    {
        $this->verifyEmailUuid = $verifyEmailUuid;

        return $this;
    }

    /**
     * Get verifyEmailUuid
     *
     * @return string
     */
    public function getVerifyEmailUuid()
    {
        return $this->verifyEmailUuid;
    }

    /**
     * Set isSuperuser
     *
     * @param boolean $isSuperuser
     * @return User
     */
    public function setIsSuperuser($isSuperuser)
    {
        $this->isSuperuser = $isSuperuser;

        return $this;
    }

    /**
     * Get isSuperuser
     *
     * @return boolean
     */
    public function getIsSuperuser()
    {
        return $this->isSuperuser;
    }

    /**
     * Set status
     *
     * @param \Zenomania\CoreBundle\Entity\UserStatus $status
     * @return User
     */
    public function setStatus(\Zenomania\CoreBundle\Entity\UserStatus $status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return \Zenomania\CoreBundle\Entity\UserStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set role
     *
     * @param \Zenomania\CoreBundle\Entity\UserRole $role
     * @return User
     */
    public function setRole(\Zenomania\CoreBundle\Entity\UserRole $role = null)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return \Zenomania\CoreBundle\Entity\UserRole
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set data from array
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
     * Set phone
     *
     * @param string $phone
     *
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set isBlocked
     *
     * @param boolean $isBlocked
     *
     * @return User
     */
    public function setIsBlocked($isBlocked)
    {
        $this->isBlocked = $isBlocked;

        return $this;
    }

    /**
     * Get isBlocked
     *
     * @return boolean
     */
    public function getIsBlocked()
    {
        return $this->isBlocked;
    }

    /**
     * Set isDeleted
     *
     * @param boolean $isDeleted
     *
     * @return User
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    /**
     * Get isDeleted
     *
     * @return boolean
     */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }

    /**
     * @return Person
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * @param Person $person
     */
    public function setPerson($person)
    {
        $this->person = $person;
    }
}
