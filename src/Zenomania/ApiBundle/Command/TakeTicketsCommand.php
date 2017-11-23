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
use Zenomania\CoreBundle\Entity\ApiToken;

class TakeTicketsCommand extends AuthenticateAwareCommand
{

    protected function configure()
    {
        $this->setName('afr:tickets:get')
            ->setDescription('Get tickets from afr service')
            ->addArgument('page', InputArgument::OPTIONAL, 'Page to start from', 1)
            ->addArgument('event', InputArgument::OPTIONAL, 'Event id to fetch tickets from');
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
        $events = $input->getArgument('event');
        $eventRepository = $this->getContainer()->get('repository.provider_events_repository');

        try {
            $user = $this->getUser();
            $token = $this->authenticateUser($user, $output);

            if (null === $events) {
                $events = $eventRepository->fetchIds();
            } else {
                $events = [$events];
            }

            foreach ($events as $eventId) {
                $this->handleEvent($token, $eventId, $page, $output);
            }

        } catch (InvalidTokenException $e) {
            $this->removeToken($user, $e->getToken()->getToken());
            $output->writeln("<error>" . $e->getMessage() . "</error>");
        } catch (\Exception $e) {
            $output->writeln("<error>" . $e->getMessage() . "</error>");
        }
    }

    /**
     * Fetch tickets from selected event
     *
     * @param ApiToken $token
     * @param $eventId
     * @param $page
     * @param OutputInterface $output
     */
    protected function handleEvent(ApiToken $token, $eventId, $page, OutputInterface $output)
    {
        $handler = $this->getContainer()->get('api.afr_tickets_handler');
        $service = $this->getIntegrationService();

        $total = 0;
        while (true) {
            $tickets = $service->fetchTickets($token, $eventId, $page);
            if (empty($tickets)) {
                break;
            }
            $output->writeln(sprintf("[Event %d] Got %d tickets from page %d", $eventId, count($tickets), $page));
            $handler->handle($tickets, $eventId);
            $output->writeln(sprintf("[Event %d] Saved %d tickets from page %d", $eventId, count($tickets), $page));
            $page++;
            $total += count($tickets);
        }

        $output->writeln(sprintf("<info>[Event %d] Saved %d tickets</info>", $eventId, $total));
    }
}