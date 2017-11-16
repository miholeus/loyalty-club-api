<?php
/**
 * @package    Zenomania\ApiBundle\Command
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Output\OutputInterface;
use Zenomania\CoreBundle\Entity\User;

/**
 * Class is used to alleviate interaction between services
 * It consists methods to authenticate user on remote system
 */
abstract class AuthenticateAwareCommand extends ContainerAwareCommand
{
    const BOT_USER = 'bot_user';

    /**
     * Gets bot user for authentication
     *
     * @return null|\Zenomania\CoreBundle\Entity\User
     */
    protected function getUser()
    {
        $userService = $this->getContainer()->get('user.service');

        $user = $userService->findByLogin(self::BOT_USER);
        return $user;
    }

    /**
     * @return int
     */
    protected function getClubId()
    {
        $clubId = $this->getContainer()->getParameter('afr_service_zenit_club_id');
        return $clubId;
    }
    /**
     * @return \Zenomania\ApiBundle\Service\Afr\ApiTokenAuthenticator
     */
    protected function getAuthenticator()
    {
        $authenticator = $this->getContainer()->get('api.afr_token_authenticator');
        return $authenticator;
    }
    /**
     * @param User $user
     * @param OutputInterface $output
     * @return \Zenomania\CoreBundle\Entity\ApiToken
     */
    protected function authenticateUser(User $user, OutputInterface $output)
    {
        $authenticator = $this->getAuthenticator();
        $service = $this->getIntegrationService();

        if (null === ($token = $authenticator->getCurrentToken($user))) {
            $token = $authenticator->authenticate($user, $service->getToken());
            $output->writeln(sprintf("<info>Authenticated with token %s</info>", $token->getToken()));
        } else {
            $output->writeln(sprintf("<info>Got current token %s</info>", $token->getToken()));
        }
        return $token;
    }

    /**
     * @return \Zenomania\ApiBundle\Service\Afr\IntegrationService
     */
    protected function getIntegrationService()
    {
        $service = $this->getContainer()->get('api.afr_integration');

        return $service;
    }

    /**
     * Removes user token
     *
     * @param User $user
     * @param string $token
     */
    protected function removeToken(User $user, string $token)
    {
        $authenticator = $this->getAuthenticator();
        $authenticator->getTokenService()->removeToken($user, $token);
    }
}