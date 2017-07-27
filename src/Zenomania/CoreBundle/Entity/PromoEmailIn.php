<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * PromoEmailIn
 */
class PromoEmailIn
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $email = '0';

    /**
     * @var string
     */
    private $token = '\'\'';

    /**
     * @var \DateTime
     */
    private $datetime;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $special = 'NONE';

    /**
     * @var \Zenomania\CoreBundle\Entity\Person
     */
    private $person;


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
     * @return PromoEmailIn
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
     * Set token
     *
     * @param string $token
     *
     * @return PromoEmailIn
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
     * Set datetime
     *
     * @param \DateTime $datetime
     *
     * @return PromoEmailIn
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * Get datetime
     *
     * @return \DateTime
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return PromoEmailIn
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set special
     *
     * @param string $special
     *
     * @return PromoEmailIn
     */
    public function setSpecial($special)
    {
        $this->special = $special;

        return $this;
    }

    /**
     * Get special
     *
     * @return string
     */
    public function getSpecial()
    {
        return $this->special;
    }

    /**
     * Set person
     *
     * @param \Zenomania\CoreBundle\Entity\Person $person
     *
     * @return PromoEmailIn
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
}
