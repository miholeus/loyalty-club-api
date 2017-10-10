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

        /** Подключаем все необходимые репозитории и сервисы */
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $eventAttendanceImportRepository = $em->getRepository('ZenomaniaCoreBundle:EventAttendanceImport');
        $eventRepository = $em->getRepository('ZenomaniaCoreBundle:Event');


        $event = $eventRepository->findEventById($eventId);

        if (empty($event)) {
            $output->writeln("<info>Нет мероприятия с таким id.</info>");
        }

        // Получаем данные по всем проходам по абонементам для заданного мероприятия
        $visitBySubs = $eventAttendanceImportRepository->findAttendanceByEvent($event);

        foreach ($visitBySubs as $visitBySub) {
            /**
             * @todo Ищем по майферу абика соответствием в таблице subscription
             * Если нашли и есть у него person_id то продолжаем иначе переходим к другой записи
             *
             * в event_attendance_import записываем person_id
             * в event_attendance записываем новую запись
             * в person_points записываем новую запись тем самым добавляя очки болельщику
             */
        }

        $output->writeln("<info>The end of adding points</info>");
    }
}