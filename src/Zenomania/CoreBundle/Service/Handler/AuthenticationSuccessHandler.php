<?php
/**
 * @package    Zenomania\CoreBundle\Service\Handler
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */

namespace Zenomania\CoreBundle\Service\Handler;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationSuccessHandler;
use Symfony\Component\Security\Http\HttpUtils;

class AuthenticationSuccessHandler extends DefaultAuthenticationSuccessHandler
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(HttpUtils $httpUtils, ContainerInterface $container, array $options)
    {
        parent::__construct($httpUtils, $options);
        $this->container = $container;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        /** @var \Zenomania\CoreBundle\Entity\User $user */
        $user = $token->getUser();

        // create token for user's api functions
        $keyProvider = $this->container->get('api.key_provider');
        $apiToken = $keyProvider->generateToken($user);
        $token->setAttribute('api_token', $apiToken);

        $this->container->get('user.service')->updateLastLoginTime($user);

        return $this->httpUtils->createRedirectResponse($request, $this->determineTargetUrl($request));
    }
}
