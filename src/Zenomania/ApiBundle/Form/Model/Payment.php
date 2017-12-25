<?php
/**
 * Created by PhpStorm.
 * User: igorvolkov
 * Date: 26.12.2017
 * Time: 1:19
 */

namespace Zenomania\ApiBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

class Payment
{

    /**
     * @var float
     * @Assert\NotBlank()
     */
    private $amount;

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }
}