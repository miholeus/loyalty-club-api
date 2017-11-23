<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 21.11.17
 * Time: 11:59
 */

namespace Zenomania\ApiBundle\Form\Model;


use Symfony\Component\Validator\Constraint as Assert;

class OrderDelivery
{
    /**
     * @var string
     */
    private $clientName;

    /**
     * @Assert\NotBlank()
     * @var integer
     */
    private $phone;

    /**
     * @var string
     */
    private $address;

    /**
     * @var integer
     */
    private $deliveryTypeId;

    /**
     * @var string
     */
    private $note;

    /**
     * @return string
     */
    public function getClientName()
    {
        return $this->clientName;
    }

    /**
     * @param string $clientName
     */
    public function setClientName($clientName)
    {
        $this->clientName = $clientName;
    }

    /**
     * @return int
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param int $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return int
     */
    public function getDeliveryTypeId()
    {
        return $this->deliveryTypeId;
    }

    /**
     * @param int $deliveryTypeId
     */
    public function setDeliveryTypeId($deliveryTypeId)
    {
        $this->deliveryTypeId = $deliveryTypeId;
    }

    /**
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param string $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }
}