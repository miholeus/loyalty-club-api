<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * Sportomat
 */
class Sportomat
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $fname;

    /**
     * @var string
     */
    private $lname;

    /**
     * @var string
     */
    private $testresult;

    /**
     * @var string
     */
    private $favsport;

    /**
     * @var \DateTime
     */
    private $dt;


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
     * Set email
     *
     * @param string $email
     *
     * @return Sportomat
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
     * Set fname
     *
     * @param string $fname
     *
     * @return Sportomat
     */
    public function setFname($fname)
    {
        $this->fname = $fname;

        return $this;
    }

    /**
     * Get fname
     *
     * @return string
     */
    public function getFname()
    {
        return $this->fname;
    }

    /**
     * Set lname
     *
     * @param string $lname
     *
     * @return Sportomat
     */
    public function setLname($lname)
    {
        $this->lname = $lname;

        return $this;
    }

    /**
     * Get lname
     *
     * @return string
     */
    public function getLname()
    {
        return $this->lname;
    }

    /**
     * Set testresult
     *
     * @param string $testresult
     *
     * @return Sportomat
     */
    public function setTestresult($testresult)
    {
        $this->testresult = $testresult;

        return $this;
    }

    /**
     * Get testresult
     *
     * @return string
     */
    public function getTestresult()
    {
        return $this->testresult;
    }

    /**
     * Set favsport
     *
     * @param string $favsport
     *
     * @return Sportomat
     */
    public function setFavsport($favsport)
    {
        $this->favsport = $favsport;

        return $this;
    }

    /**
     * Get favsport
     *
     * @return string
     */
    public function getFavsport()
    {
        return $this->favsport;
    }

    /**
     * Set dt
     *
     * @param \DateTime $dt
     *
     * @return Sportomat
     */
    public function setDt($dt)
    {
        $this->dt = $dt;

        return $this;
    }

    /**
     * Get dt
     *
     * @return \DateTime
     */
    public function getDt()
    {
        return $this->dt;
    }
}
