<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 14.09.17
 * Time: 15:14
 */

namespace Zenomania\ApiBundle\Form\Model;

use Zenomania\CoreBundle\Entity\City;
use Zenomania\CoreBundle\Entity\District;
use Zenomania\CoreBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

class UserProfile
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $firstName;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $lastName;

    /**
     * @var string
     */
    private $middleName;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $email;

    /**
     * @var City
     */
    private $city;

    /**
     * @var District
     */
    private $district;

    /**
     * @var string
     */
    private $birthDate;
    /**
     * @var User
     * @Assert\NotBlank()
     */
    private $user;
    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getMiddleName()
    {
        return $this->middleName;
    }

    /**
     * @param string $middleName
     */
    public function setMiddleName(string $middleName)
    {
        $this->middleName = $middleName;
    }

    /**
     * @return string
     */
    public function getEmail()
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
     * @return City
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param City $city
     */
    public function setCity(City $city)
    {
        $this->city = $city;
    }

    /**
     * @return District
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * @param District $district
     */
    public function setDistrict(District $district)
    {
        $this->district = $district;
    }

    /**
     * @return string
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @param string $birthDate
     */
    public function setBirthDate(string $birthDate)
    {
        $this->birthDate = $birthDate;
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
     * Populates user data
     */
    public function populateUser()
    {
        $this->getUser()->setFirstname($this->getFirstName());
        $this->getUser()->setLastname($this->getLastName());
        $this->getUser()->setMiddlename($this->getMiddleName());
        $this->getUser()->setBirthDate(new \DateTime($this->getBirthDate()));
        $this->getUser()->setEmail($this->getEmail());
    }
}