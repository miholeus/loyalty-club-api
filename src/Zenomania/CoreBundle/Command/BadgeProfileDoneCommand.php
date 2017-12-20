<?php
/**
 * Created by PhpStorm.
 * User: igorvolkov
 * Date: 20.12.2017
 * Time: 0:01
 */

namespace Zenomania\CoreBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Event\User\ProfileEvent;
use Zenomania\CoreBundle\Service\Traits\EventsAwareTrait;

class BadgeProfileDoneCommand extends ContainerAwareCommand
{
    use EventsAwareTrait;

    protected function configure()
    {
        $this->setName('badge:profile:done');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->notificationManager = $this->getContainer()->get('event.notification_manager');
        $repository = $this->getContainer()->get('repository.user_repository');
        $users = $repository->findAll();
        foreach ($users as $user) {
            /** @var User $user */
            $output->writeln(sprintf("<info>Проверям анкету пользователю %s </info>", $user->__toString()));

            $event = new ProfileEvent();
            $event->setArgument('user', $user);
            $this->attachEvent($event);
            $this->updateEvents();
        }
        $output->writeln("<info>Беджи выданы</info>");
    }
}