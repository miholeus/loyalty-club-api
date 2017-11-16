<?php
/**
 * @package    Zenomania\ApiBundle\Command
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zenomania\ApiBundle\Service\Afr\InvalidTokenException;

class TakeClubsCommand extends AuthenticateAwareCommand
{
    /**
     * Volleyball sport identifier on remote system
     */
    const SPORT_ID = 7;

    protected function configure()
    {
        $this->setName('afr:clubs:get')
            ->setDescription('Get clubs from afr service');
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
        try {
            $user = $this->getUser();
            $handler = $this->getContainer()->get('api.afr_clubs_handler');

            $service = $this->getIntegrationService();

            $token = $this->authenticateUser($user, $output);

            $data = $service->fetchClubs($token, self::SPORT_ID);

            $output->writeln(sprintf("Got %d clubs", count($data)));
            $handler->handle($data);

            $output->writeln(sprintf("<info>Saved %d clubs</info>", count($data)));
        } catch (InvalidTokenException $e) {
            $this->removeToken($user, $e->getToken()->getToken());
            $output->writeln("<error>" . $e->getMessage() . "</error>");
        } catch (\Exception $e) {
            $output->writeln("<error>" . $e->getMessage() . "</error>");
        }
    }
}