<?php
/**
 * Created by PhpStorm.
 * User: igorvolkov
 * Date: 25.12.2017
 * Time: 23:52
 */

namespace Zenomania\ApiBundle\Service;

use Zenomania\CoreBundle\Entity\Payment;
use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Repository\PaymentRepository;
use Zenomania\CoreBundle\Repository\PersonPointsRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PaymentsService
{
    /**
     * @var PaymentRepository
     */
    private $paymentRepository;

    /**
     * @var PersonPointsRepository
     */
    private $personPointsRepository;

    public function __construct(PaymentRepository $paymentRepository, PersonPointsRepository $personPointsRepository)
    {
        $this->paymentRepository = $paymentRepository;
        $this->personPointsRepository = $personPointsRepository;
    }

    public function debit(int $amount, User $user)
    {
        $points = $this->getPersonPointsRepository()->getTotalPoints($user);
        if($points < $amount){
            throw new HttpException(400, 'Недостаточно поинтов');
        }
        $payment = new Payment();
        $payment->setAmount($amount);
        $payment->setType(Payment::TYPE_DEBIT);
        $payment->setUser($user);
        return $this->getPaymentRepository()->save($payment);
    }

    public function credit(\Zenomania\ApiBundle\Form\Model\Payment $paymentType, User $user)
    {
        $payment = new Payment();
        $payment->setAmount($paymentType->getAmount());
        $payment->setType(Payment::TYPE_CREDIT);
        $payment->setUser($user);
        return $this->getPaymentRepository()->save($payment);
    }

    /**
     * @return PaymentRepository
     */
    public function getPaymentRepository()
    {
        return $this->paymentRepository;
    }

    /**
     * @return PersonPointsRepository
     */
    public function getPersonPointsRepository()
    {
        return $this->personPointsRepository;
    }
}