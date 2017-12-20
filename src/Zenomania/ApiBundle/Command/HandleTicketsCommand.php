<?php
/**
 * @package    Zenomania\ApiBundle\Command
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;


class HandleTicketsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('afr:tickets:handle')
            ->setDescription('Handle saved tickets');
    }

    /**
     * Handle saved tickets
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $handler = $this->getContainer()->get('api.afr_tickets_handler');

        $limit = 1000;
        $offset = 0;
        $cnt = 0;
        try {
            while (true) {
                $tickets = $handler->getNewTickets($limit, $offset);
                if (empty($tickets)) {
                    break;
                }
                $handler->handle($tickets);
                $cnt += count($tickets);
                $output->writeln("<info>Saved %d tickets</info>", $cnt);
                $offset = $offset + 1000;
            }
        } catch (\Exception $e) {
            $output->writeln("<error>" . $e->getMessage() . "</error>");
        }
    }
}