<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 28.08.2017
 * Time: 16:00
 */

namespace Zenomania\ApiBundle\Service;


use Hashids\Hashids;
use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Entity\UserReferralCode;
use Zenomania\CoreBundle\Repository\UserReferralCodeRepository;

class Invite
{

    /** @var UserReferralCodeRepository */
    private $userReferralCodeRepository;

    public function __construct(UserReferralCodeRepository $userReferralCodeRepository)
    {
        $this->userReferralCodeRepository = $userReferralCodeRepository;
    }
    /**
     * @return string
     */
    public function getEmailFrom()
    {
        return 'info@zenomania.ru';
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return 'Приглашение от друга вступить в Зеноманию';
    }

    /**
     * @param string $code
     * @return string
     */
    public function getBodyEmail(string $code)
    {
        $template = 'Регистрируйся в зеномании по ссылке: http://zenomania.ru/join?ref={{REFCODE}}. Шаблон {{REFCODE}} надо заменить на код для каждого конретного пользователя, который делает приглашение.';

        $body = str_replace('{{REFCODE}}', $code, $template);

        return $body;
    }

    /**
     * @param string $phone
     * @return string
     */
    private function generateCodeFromPhone(string $phone)
    {
        $hashids = new Hashids();
        return $hashids->encode($phone);
    }

    /**
     * @param string $emailTo Кому отправить
     * @param User $user Кто отправляет
     * @param \Swift_Mailer $mailer Почтовая служба
     * @return mixed
     */
    public function sendInvite(string $emailTo, User $user, \Swift_Mailer $mailer)
    {
        $code = $this->getCodeForUser($user);

        $from = $this->getEmailFrom();
        $to = $emailTo;
        $subject = $this->getSubject();
        $body = $this->getBodyEmail($code);

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($from)
            ->setTo($to)
            ->setBody($body);

        return $mailer->send($message);
    }

    /**
     * @return UserReferralCodeRepository
     */
    public function getUserReferralCodeRepository(): UserReferralCodeRepository
    {
        return $this->userReferralCodeRepository;
    }

    /**
     * @param User $user
     * @return string
     */
    private function getCodeForUser(User $user): string
    {
        $userReferralCode = $this->getUserReferralCodeRepository()->findCodeByUser($user);

        if (null === $userReferralCode) {
            $code = $this->generateCodeFromPhone($user->getPhone());

            $params = [
                'user' => $user,
                'refCode' => $code,
                'activated' => false,
                'activations' => 0,
                'dateCreated' => new \DateTime(),
                'dateUpdated' => new \DateTime()
            ];

            $userReferralCode = UserReferralCode::fromArray($params);
            $this->getUserReferralCodeRepository()->save($userReferralCode);
            return $code;
        } else {
            /** @var UserReferralCode $userReferralCode */
            $code = $userReferralCode->getRefCode();
            return $code;
        }
    }
}