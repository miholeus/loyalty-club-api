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

class TakeSubsCommand extends AuthenticateAwareCommand
{

    protected function configure()
    {
        $this->setName('afr:subs:get')
            ->setDescription('Get subs from afr service')
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

        try {
            $user = $this->getUser();
            $token = $this->authenticateUser($user, $output);

            $this->handleEvent($token, $page, $output);

        } catch (InvalidTokenException $e) {
            $this->removeToken($user, $e->getToken()->getToken());
            $output->writeln("<error>" . $e->getMessage() . "</error>");
        } catch (\Exception $e) {
            $output->writeln("<error>" . $e->getMessage() . "</error>");
        }
    }

    /**
     * Fetch subs from current season
     *
     * @param ApiToken $token
     * @param $page
     * @param OutputInterface $output
     */
    protected function handleEvent(ApiToken $token, $page, OutputInterface $output)
    {
        $handler = $this->getContainer()->get('api.afr_sub_handler');
        $service = $this->getIntegrationService();
        $clubId = $this->getClubId();
        $seasonRepo = $this->getContainer()->get('repository.club_season_repository');
        $season = $seasonRepo->findCurrentSeason();
        if (null === $season) {
            throw new \RuntimeException("Current season not found");
        }
        $seasonId = $season->getId();

        $total = 0;
        while (true) {
            $subs = $service->fetchSubs($token, $clubId, $page);
            if (empty($subs)) {
                break;
            }
            $output->writeln(sprintf("Got %d subs from page %d", count($subs), $page));
            $handler->saveToStorage($subs, $seasonId);
            $output->writeln(sprintf("Saved %d subs from page %d", count($subs), $page));
            $page++;
            $total += count($subs);
        }

        $output->writeln(sprintf("<info>Saved %d subs</info>", $total));
    }
}