<?php
/**
 * @package    Zenomania\ApiBundle\Command
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;


class HandleSubsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('afr:subs:handle')
            ->setDescription('Handle saved subs');
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
        $handler = $this->getContainer()->get('api.afr_sub_handler');
        $handler->attachLogger(function($message) use ($output){
            return $output->writeln($message);
        });

        $limit = 1000;
        $offset = 0;
        $cnt = 0;
        try {
            while (true) {
                $subs = $handler->getNewSubs($limit, $offset);
                if (empty($subs)) {
                    break;
                }
                $handler->handle($subs);
                $cnt += count($subs);
                $output->writeln(sprintf("<info>Saved %d subs</info>", $cnt));
                $offset = $offset + 1000;
            }
        } catch (\Exception $e) {
            $output->writeln("<error>" . $e->getMessage() . "</error>");
        }
    }
}