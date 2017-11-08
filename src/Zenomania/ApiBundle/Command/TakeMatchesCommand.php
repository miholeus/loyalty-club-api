<?php
/**
 * @package    Zenomania\ApiBundle\Command
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zenomania\CoreBundle\Entity\ApiToken;

class TakeMatchesCommand extends ContainerAwareCommand
{
    const BOT_USER = 'bot_user';

    protected function configure()
    {
        $this->setName('afr:events:get')
            ->setDescription('Get events from afr service')
            ->addArgument('page', InputArgument::OPTIONAL, 'Page to start from');
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
        $clubId = $this->getContainer()->getParameter('afr_service_zenit_club_id');

        try {
            $userService = $this->getContainer()->get('user.service');
            $eventService = $this->getContainer()->get('event.service');
            $user = $userService->findByLogin(self::BOT_USER);

            $service = $this->getContainer()->get('api.afr_integration');
            $authenticator = $this->getContainer()->get('api.afr_token_authenticator');
            $token = $authenticator->authenticate($user, $service->getToken());
            $output->writeln(sprintf("Authenticated with token %s", $token->getToken()));

            $events = $service->fetchMatches($token, $clubId, $page);
            // @Todo save events

            $output->writeln("<info>Saved events</info>");
        } catch (\Exception $e) {
            $output->writeln("<error>" . $e->getMessage() . "</error>");
        }
    }
}