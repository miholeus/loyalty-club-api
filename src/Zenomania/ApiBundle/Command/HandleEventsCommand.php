<?php
/**
 * @package    Zenomania\ApiBundle\Command
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;


class HandleEventsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('afr:events:handle')
            ->setDescription('Handle saved matches');
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
        $handler = $this->getContainer()->get('api.afr_matches_handler');
        $handler->attachLogger(function($message) use ($output){
            return $output->writeln($message);
        });

        $limit = 100;
        $offset = 0;
        $cnt = 0;
        try {
            while (true) {
                $events = $handler->getNewEvents($limit, $offset);
                if (empty($events)) {
                    break;
                }
                $cnt += count($events);
                $handler->handle($events);
                $output->writeln("<info>Saved %d events</info>", $cnt);
                $offset = $offset + 1000;
            }
        } catch (\Exception $e) {
            $output->writeln("<error>" . $e->getMessage() . "</error>");
        }
    }
}