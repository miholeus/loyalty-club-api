<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 13.10.2017
 * Time: 14:19
 */

namespace Zenomania\CoreBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NewRepostCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this->setName('repost:new')
            ->setDescription('Search for new repost');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("<info>The start search for new repost</info>");

        /** Подключаем все необходимые репозитории и сервисы */
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $serviceVk = $this->getContainer()->get('api.client.vk');

        // Получить список всех постов для проверки (записи у ко-ых в таблице с постами поле Status = NEW)
        $posts = [1];

        foreach ($posts as $post) {
            // Получить все репосты для заданного поста
            $reposts = $serviceVk->getReposts($post);
            foreach ($reposts as $repost) {
                echo $repost->to_id . PHP_EOL;
            }
        }

        // Проверить когда был сделан репост, в течении 24 часов с момента поста или нет
        // Если в течении 24 часов, то проверить есть он уже в базе или нет
        // Если еще нет, то добавить информацию о репостах в таблицу
        // При добавлении информации о репосте, начислить баллы пользователю

        // Если с момента опубликования поста прошло более 24 часов, то перевести пост в статус = CHECKED



        $output->writeln("<info>The end search for new repost</info>");
    }
}