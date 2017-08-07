<?php
/**
 * @package    Zenomania\CoreBundle\Form\Model
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */

namespace Zenomania\CoreBundle\Form\Model;


class UpdatePhone extends BaseModel implements TokenInterface
{
    /**
     * Phone
     *
     * @var string
     */
    protected $phone;
    /**
     * Code
     *
     * @var string
     */
    protected $code;
    /**
     * @var string
     */
    protected $token;

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function setToken($token)
    {
        $this->token = $token;
    }
}
