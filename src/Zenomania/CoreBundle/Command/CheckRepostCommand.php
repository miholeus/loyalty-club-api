<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 17.10.2017
 * Time: 15:29
 */

namespace Zenomania\CoreBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CheckRepostCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this->setName('repost:check')
            ->setDescription('Checking repost for deletion');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("<info>Start checking repost</info>");

        /** Подключаем все необходимые репозитории и сервисы */
        $serviceNews = $this->getContainer()->get('news.service');
        $serviceVk = $this->getContainer()->get('api.client.vk');

        /** Получаем все новости, которые находятся под контролем */
        $posts = $serviceNews->getAllContlolledNews();
        foreach ($posts as $post) {

            if ($serviceNews->checkTimeControlledPost($post)) {
                echo "Перевели новость из подконтролем в обработанные " . PHP_EOL;
            }

            /** Получить id всех тех, кто репостил новости и получил очки за это */
            $repost = $serviceNews->getIdThoseWhoRepost($post);
            /** Список id аккаунтов репостов на данный момент */
            $currentRepost = $serviceVk->getList($post);
            /** Массим id тех кто удалил репосты после начисления им баллов */
            $deleteRepost = array_diff($repost, $currentRepost);

            if (empty($deleteRepost)) {
                continue;
            }
            $serviceNews->removePointsForPost($deleteRepost, $post);
        }

        $output->writeln("<info>End checking repost</info>");
    }

}