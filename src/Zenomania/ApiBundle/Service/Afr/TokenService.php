<?php
/**
 * @package    Zenomania\ApiBundle\Service\Afr
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service\Afr;

use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Repository\ApiTokenRepository;

class TokenService
{
    /**
     * @var ApiTokenRepository
     */
    private $tokenRepository;

    public function __construct(ApiTokenRepository $tokenRepository)
    {
        $this->tokenRepository = $tokenRepository;
    }

    /**
     * @param User $user
     * @return mixed|null
     */
    public function getToken(User $user)
    {
        return $user->getValidToken();
    }
}