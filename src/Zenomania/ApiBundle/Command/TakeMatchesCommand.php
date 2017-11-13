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
use Zenomania\ApiBundle\Service\Afr\InvalidTokenException;
use Zenomania\CoreBundle\Entity\ApiToken;

class TakeMatchesCommand extends ContainerAwareCommand
{
    const BOT_USER = 'bot_user';

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
        $clubId = $this->getContainer()->getParameter('afr_service_zenit_club_id');

        $userService = $this->getContainer()->get('user.service');
        $authenticator = $this->getContainer()->get('api.afr_token_authenticator');

        try {
            $user = $userService->findByLogin(self::BOT_USER);
            $handler = $this->getContainer()->get('api.afr_matches_handler');

            $service = $this->getContainer()->get('api.afr_integration');

            if (null === ($token = $authenticator->getCurrentToken($user))) {
                $token = $authenticator->authenticate($user, $service->getToken());
                $output->writeln(sprintf("<info>Authenticated with token %s</info>", $token->getToken()));
            } else {
                $output->writeln(sprintf("<info>Got current token %s</info>", $token->getToken()));
            }

            $total = 0;
            while (true) {
                $events = $service->fetchMatches($token, $clubId, $page);
                if (empty($events)) {
                    break;
                }
                $output->writeln(sprintf("Got %d events from page %d", count($events), $page));
                $handler->handle($events);
                $output->writeln(sprintf("Saved %d events from page %d", count($events), $page));
                $page++;
                $total += count($events);
            }

            $output->writeln(sprintf("<info>Saved %d events</info>", $total));
        } catch (InvalidTokenException $e) {
            $authenticator->getTokenService()->removeToken($user, $e->getToken()->getToken());
            $output->writeln("<error>" . $e->getMessage() . "</error>");
        } catch (\Exception $e) {
            $output->writeln("<error>" . $e->getMessage() . "</error>");
        }
    }
}