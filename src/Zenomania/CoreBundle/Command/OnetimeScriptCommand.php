<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 23.11.2017
 * Time: 17:28
 */

namespace Zenomania\CoreBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zenomania\CoreBundle\Entity\Person;
use Zenomania\CoreBundle\Entity\User;

class OnetimeScriptCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('onetime:correction-user-id')
            ->setDescription('Correction of user_id in person_points');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("<info>The start of correction of user_id</info>");

        /** Подключаем все необходимые репозитории */
        $container = $this->getContainer();
        $personPointsRepository = $container->get('repository.person_points_repository');
        $personRepository = $container->get('repository.person_repository');
        $userRepository = $container->get('repository.user_repository');

        /** Получаем все записи в person_points у которых не указан user_id */
        $personPoints = $personPointsRepository->getNullUserId();

        if (empty($personPoints)) {
            throw new \RuntimeException("Нет данных, которые необходимо было бы корректировать");
        }

        foreach ($personPoints as $personPoint) {
            /** @var Person $person */
            $person = $personRepository->find($personPoint['person']);
            /** @var User[] $user */
            $user = $userRepository->findUserByPerson($person);

            if (1 <> count($user)) {
                $output->writeln("<error>Нет однозначного соответствия между данными user и person</error>");
                continue;
            }

            $res = $personPointsRepository->updateUserByPerson($person, $user[0]);
            $output->writeln("<info>Обновили {$res} записей</info>");
        }


        $output->writeln("<info>The end of correction of user_id</info>");
    }
}