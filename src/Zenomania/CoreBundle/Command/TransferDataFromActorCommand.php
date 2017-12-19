<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 15.09.2017
 * Time: 16:31
 */

namespace Zenomania\CoreBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zenomania\CoreBundle\Entity\Actor;
use Zenomania\CoreBundle\Entity\DeviceToken;
use Zenomania\CoreBundle\Entity\Person;
use Zenomania\CoreBundle\Entity\SocialAccount;
use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Entity\UserRole;
use Zenomania\CoreBundle\Entity\UserStatus;
use Zenomania\CoreBundle\Repository\PersonRepository;
use Zenomania\CoreBundle\Repository\UserRepository;
use Zenomania\CoreBundle\Service\TransferActorService;


/**
 * Transfer data from table Actor to table User
 */
class TransferDataFromActorCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this->setName('transfer:actor')
            ->setDescription('Transfer data from Actor to User');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("<info>The start transfer data from actor</info>");

        /** Подключаем все необходимые репозитории и сервисы */
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        /** @var PersonRepository $personRepository */
        $personRepository = $em->getRepository('ZenomaniaCoreBundle:Person');
        /** @var UserRepository $userRepository */
        $userRepository = $em->getRepository('ZenomaniaCoreBundle:User');
        /** @var TransferActorService $service */
        $service = $this->getContainer()->get('transfer_actor.service');

        $service->setUserStatus($em->getRepository('ZenomaniaCoreBundle:UserStatus')->findOneBy(['code' => UserStatus::STATUS_ACTIVE]));
        $service->setUserRole($em->getRepository('ZenomaniaCoreBundle:UserRole')->findOneBy(['name' => UserRole::ROLE_USER]));


        /** Получаем все записи из таблицы actor */
        /** @var Actor $actor */
        $actors = $em->getRepository('ZenomaniaCoreBundle:Actor')->findAll();
        foreach ($actors as $actor) {
            /** @var Person $person */
            $person = $personRepository->findPersonByActor($actor);

            $login = $actor->getUsername();
            $phone = preg_replace('/\D/', '', $person->getMobile());
            if ($userRepository->existsUserByLoginOrPhone($login, $phone)) {
                $output->writeln("<info>User with login|phone (" . $login . "|" . $phone . ") exists</info>");
                continue;
            }

            $service->transfer($actor, $person);

            $output->writeln("<info>Success data transfer for actor with id (" . $actor->getId() . ")</info>");
        }
        $output->writeln("<info>The end transfer data from actor</info>");
    }
}
