<?php
/**
 * @package    Zenomania\ApiBundle\Command
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zenomania\ApiBundle\Service\Afr\InvalidTokenException;

class TakeEventsCommand extends AuthenticateAwareCommand
{
    protected function configure()
    {
        $this->setName('afr:events:get')
            ->setDescription('Get events from afr service')
            ->addArgument('page', InputArgument::OPTIONAL, 'Page to start from', 1);
    }

    /**
     * Generate api keys
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $page = $input->getArgument('page');
        $clubId = $this->getClubId();

        try {
            $user = $this->getUser();
            $handler = $this->getContainer()->get('api.afr_matches_handler');

            $service = $this->getIntegrationService();

            $token = $this->authenticateUser($user, $output);

            $total = 0;
            while (true) {
                $events = $service->fetchEvents($token, $clubId, $page);
                if (empty($events)) {
                    break;
                }
                $output->writeln(sprintf("Got %d events from page %d", count($events), $page));
                $handler->saveToStorage($events);
                $output->writeln(sprintf("Saved %d events from page %d", count($events), $page));
                $page++;
                $total += count($events);
            }

            $output->writeln(sprintf("<info>Saved %d events</info>", $total));
        } catch (InvalidTokenException $e) {
            $this->removeToken($user, $e->getToken()->getToken());
            $output->writeln("<error>" . $e->getMessage() . "</error>");
        } catch (\Exception $e) {
            $output->writeln("<error>" . $e->getMessage() . "</error>");
        }
    }
}