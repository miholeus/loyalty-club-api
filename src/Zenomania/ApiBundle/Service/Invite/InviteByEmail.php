<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 28.08.2017
 * Time: 16:00
 */

namespace Zenomania\ApiBundle\Service\Invite;

use Symfony\Bundle\TwigBundle\TwigEngine;

class InviteByEmail
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * Mail from
     *
     * @var string
     */
    private $mailFrom;
    /**
     * @var TwigEngine
     */
    private $twig;

    public function __construct(\Swift_Mailer $mailer, string $mailFrom, TwigEngine $twig)
    {
        $this->mailer = $mailer;
        $this->mailFrom = $mailFrom;
        $this->twig = $twig;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return 'Приглашение от друга вступить в Зеноманию';
    }

    /**
     * @param string $emailTo Кому отправить
     * @param string $code код для отправки
     * @param string $url url для регистрации
     * @return mixed
     */
    public function send(string $emailTo, string $code, string $url)
    {
        $from = $this->getMailFrom();
        $to = $emailTo;
        $subject = $this->getSubject();

        $message = (new \Swift_Message($subject))
            ->setFrom($from)
            ->setTo($to)
            ->setBody($this->getTwig()->render('ZenomaniaApiBundle:Emails:invite.html.twig', [
                'registration_url' => $url,
                'ref_code' => $code
            ]), 'text/html');

        return $this->getMailer()->send($message);
    }

    /**
     * @return \Swift_Mailer
     */
    public function getMailer(): \Swift_Mailer
    {
        return $this->mailer;
    }

    /**
     * @return string
     */
    public function getMailFrom(): string
    {
        return $this->mailFrom;
    }

    /**
     * @return TwigEngine
     */
    public function getTwig(): TwigEngine
    {
        return $this->twig;
    }
}