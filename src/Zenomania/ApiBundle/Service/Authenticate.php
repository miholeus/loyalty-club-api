<?php
/**
 * @package    Zenomania\ApiBundle\Service
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */

namespace Zenomania\ApiBundle\Service;

use Zenomania\ApiBundle\Service\Exception\AuthenticateException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Zenomania\CoreBundle\Repository\UserRepository;

/**
 * Authenticate service
 */
class Authenticate
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var UserPasswordEncoder
     */
    private $encoder;

    public function __construct(UserRepository $userRepository, UserPasswordEncoder $encoder)
    {
        $this->userRepository = $userRepository;
        $this->encoder = $encoder;
    }

    /**
     * Returns authenticated user
     *
     * @param $phone
     * @param $password
     * @return \Zenomania\CoreBundle\Entity\User
     */
    public function authenticate($phone, $password)
    {
        if (empty($phone) || empty($password)) {
            throw new HttpException(400, 'Bad Request');
        }

        $user = $this->findUserByPhone($phone);

        if (!$this->getEncoder()->isPasswordValid($user, $password)) {
            throw new AuthenticateException(401, "Неверные данные для аутентификации");
        } elseif ($user->getIsBlocked()) {
            throw new AuthenticateException(403, "Учетная запись заблокирована. Обратитесь к администратору.");
        }

        return $user;
    }

    /**
     * @param $phone
     * @return \Zenomania\CoreBundle\Entity\User
     */
    public function findUserByPhone($phone)
    {
        /** @var \Zenomania\CoreBundle\Entity\User $user */
        $user = $this->getUserRepository()->findOneBy(['phone' => $phone]);
        if (null === $user) {
            throw new HttpException(404, 'Пользователь не найден');
        }
        return $user;
    }

    /**
     * @return UserRepository
     */
    public function getUserRepository()
    {
        return $this->userRepository;
    }

    /**
     * @return UserPasswordEncoder
     */
    public function getEncoder()
    {
        return $this->encoder;
    }

    /**
     * Check if user with phone exists
     *
     * @param $phone
     * @return bool
     */
    public function validPhone($phone)
    {
        $user = $this->getUserRepository()->findOneBy(['phone' => $phone]);
        if (null === $user) {
            return false;
        }
        return true;
    }
}
