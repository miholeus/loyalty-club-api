<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 10.10.2017
 * Time: 14:43
 */

namespace Zenomania\CoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zenomania\CoreBundle\Entity\EventAttendance;
use Zenomania\CoreBundle\Entity\EventAttendanceImport;
use Zenomania\CoreBundle\Entity\PersonPoints;

class AttendanceCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('attendance:bysubs')
            ->setDescription('Add points for attendance by subscription')
            ->addArgument(
                'event',
                InputArgument::REQUIRED,
                'Event number'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $eventId = $input->getArgument('event');

        /** Подключаем все необходимые репозитории */
        $container = $this->getContainer();
        $eventRepository = $container->get('repository.event_repository');
        $personPointsRepository = $container->get('repository.person_points_repository');
        $eventAttendanceRepository = $container->get('repository.event_attendance_repository');
        $subscriptionRepository = $container->get('repository.subscription_repository');
        $eventAttendanceImportRepository = $container->get('repository.event_attendance_import_repository');
        $bonusPointsService = $container->get('points.attendance');

        $event = $eventRepository->findEventById($eventId);

        if (empty($event)) {
            throw new \RuntimeException("Нет мероприятия с таким id");
        }

        $output->writeln("<info>The start of adding points</info>");

        // Получаем данные по всем проходам по абонементам для заданного мероприятия
        $visitBySubs = $eventAttendanceImportRepository->findAttendanceByEvent($event);

        /** @var EventAttendanceImport $visitBySub */
        foreach ($visitBySubs as $visitBySub) {
            // Ищем абонемент по заданному Mifare
            $subscription = $subscriptionRepository->findSubsByMifare($visitBySub->getSubscriptionNumber());

            // Если абонемент не найден или он не привязан к пользователю, то переходим к другому
            if (empty($subscription) || empty($subscription->getPerson())) {
                $output->writeln("<info>Абонемент {$subscription->getMifare()} не найден</info>");
                continue;
            }

            // Записываем в данные по проходу владельца абонемента
            $visitBySub->setPerson($subscription->getPerson());
            $eventAttendanceImportRepository->save($visitBySub);

            // Записываем в таблицу проходов event_attendance новые данные
            $params = [
                'event' => $visitBySub->getEvent(),
                'person' => $subscription->getPerson(),
                'subscriptionId' => $subscription->getId(),
                'enterDate' => $visitBySub->getEnterDt()
            ];

            $eventAttendance = EventAttendance::fromArray($params);
            $eventAttendanceRepository->save($eventAttendance);

            $points = $bonusPointsService->getAttendance()->getPoints($visitBySub);

            if (!empty($points)) {
                $user = $subscription->getPerson()->getUser();
                $personPointsRepository->givePointsForSubscriptionAttendance($user, $points);
                $output->writeln("<info>Пользователю {$user->getId()} начислено {$points} баллов</info>");
            }
        }

        $output->writeln("<info>The end of adding points</info>");
    }
}