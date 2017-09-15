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


/**
 * Transfer data from table Actor to table User
 */
class TransferDataFromActor extends ContainerAwareCommand
{

    protected function configure()
    {
        $this->setName('transfer:actor')
            ->setDescription('Transfer data from Actor to User');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("<info>The end transfer data from actor</info>");
    }
}