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

class BadgeRegistrationCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('badge:registration');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $repository = $this->getContainer()->get('repository.badge_repository');
        $service = $this->getContainer()->get('user_badge.service');
        $users = $repository->getUsersNeedBadgeRegistrations();
        if($users) {
            foreach ($users as $user) {
                /** @var User $user */
                $user = $this->getContainer()->get('repository.user_repository')->findOneBy(['id' => $user['id']]);
                $output->writeln(sprintf("<info>Выдаем бейдж за регистрацию пользователю %s </info>", $user->__toString()));
                $service->giveBadgeForRegistrations($user);
            }
            $output->writeln("<info>Беджи выданы</info>");
        }else{
            $output->writeln("<info>Пользователи не найдены</info>");
        }
    }
}