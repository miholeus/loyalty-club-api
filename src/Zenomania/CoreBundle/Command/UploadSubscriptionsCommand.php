<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 30.10.2017
 * Time: 15:25
 */

namespace Zenomania\CoreBundle\Command;



use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UploadSubscriptionsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('subscription:upload')
            ->setDescription('Upload subscription cards VK Zenit 17-18')
            ->addArgument(
                'file',
                InputArgument::REQUIRED,
                'Filename for uploading'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("<info>The start uploading subscriptions to the database</info>");

        $fileName = $this->getFullPath($input->getArgument('file'));

        $parser = $this->getContainer()->get('promocoupon.parser');
        $data = $parser->getData($fileName);

        $service = $this->getContainer()->get('subscription.service');
        $result = $service->addFromFile($data);

        $output->writeln("<info>Добавили абонементов:</info>" . $result['new']);
        $output->writeln("<info>Дублей:</info>" . $result['duplicate']);
        $output->writeln("<info>Ошибок:</info>" . $result['error']);
        $output->writeln("<info>The end uploading subscriptions</info>");
    }

    /**
     * @param string $file
     * @return string
     */
    protected function getFullPath(string $file): string
    {
        return $this->getContainer()->getParameter('upload_dir') .
            DIRECTORY_SEPARATOR .
            $this->getContainer()->getParameter('upload_subscriptions_dir') .
            DIRECTORY_SEPARATOR .
            $file;
    }
}