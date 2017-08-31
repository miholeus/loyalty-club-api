<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 28.08.2017
 * Time: 16:00
 */

namespace Zenomania\ApiBundle\Service;


use Zenomania\CoreBundle\Entity\User;

class Invite
{

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
     * @param User $user
     * @return string
     */
    public function getBodyEmailForUser(User $user)
    {
        $template = 'Регистрируйся в зеномании по ссылке: http://zenomania.ru/join?ref={{REFCODE}}. Шаблон {{REFCODE}} надо заменить на код для каждого конретного пользователя, который делает приглашение.';

        $body = str_replace('{{REFCODE}}', $user->getPhone(), $template);

        return $body;
    }

    /**
     * @param string $emailTo
     * @param User $user
     * @param \Swift_Mailer $mailer
     * @return mixed
     */
    public function sendInvite(string $emailTo, User $user, \Swift_Mailer $mailer)
    {

        $from = $this->getEmailFrom();
        $to = $emailTo;
        $subject = $this->getSubject();
        $body = $this->getBodyEmailForUser($user);

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($from)
            ->setTo($to)
            ->setBody($body);

        return $mailer->send($message);
    }
}