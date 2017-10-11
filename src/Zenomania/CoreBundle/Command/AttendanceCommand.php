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


        $output->writeln("<info>The start of adding points</info>");

        /** Подключаем все необходимые репозитории */
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $eventAttendanceImportRepository = $em->getRepository('ZenomaniaCoreBundle:EventAttendanceImport');
        $eventAttendanceRepository = $em->getRepository('ZenomaniaCoreBundle:EventAttendance');
        $eventRepository = $em->getRepository('ZenomaniaCoreBundle:Event');
        $subscriptionRepository = $em->getRepository('ZenomaniaCoreBundle:Subscription');
        $personPointsRepository = $em->getRepository('ZenomaniaCoreBundle:PersonPoints');
        $pointsTypeRepository = $em->getRepository('ZenomaniaCoreBundle:PointsType');


        $event = $eventRepository->findEventById($eventId);

        if (empty($event)) {
            $output->writeln("<info>Нет мероприятия с таким id.</info>");
            exit();
        }

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

            /** Вычисляем время до начала мероприятия, за которое болельщик пришел на стадион */
            $timeAttendance = $visitBySub->getEnterDt()->getTimestamp();
            $timeEvent = $visitBySub->getEvent()->getDate()->getTimestamp();
            $interval = intval(ceil(($timeEvent - $timeAttendance) / 60));

            /** Получаем количество процентов для начисления баллов и итогое кол-во баллов */
            $pointsType = $pointsTypeRepository->findPercentByTypeAndInterval(PersonPoints::TYPE_SUBSCRIPTION_ATTENDANCE, $interval);

            if (!empty($pointsType)) {
                $percent = $pointsType->getPercent();
                $points = round($visitBySub->getPrice() * $percent / 100);
                $user = $subscription->getPerson()->getUser();
                $personPointsRepository->givePointsForSubscriptionAttendance($user, $points);
                $output->writeln("<info>Пользователю {$user->getId()} начислено {$points} баллов</info>");
            }
        }

        $output->writeln("<info>The end of adding points</info>");
    }
}