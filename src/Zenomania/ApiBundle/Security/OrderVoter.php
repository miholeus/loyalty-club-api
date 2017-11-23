<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 23.11.17
 * Time: 15:30
 */

namespace Zenomania\ApiBundle\Security;


use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Zenomania\CoreBundle\Entity\Order;
use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Entity\UserRole;

class OrderVoter extends Voter
{
    const VIEW = 'view';

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, array(self::VIEW))) {
            return false;
        }

        if (!$subject instanceof Order) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        if (in_array($user->getRole()->getName(), [UserRole::ROLE_ADMIN, UserRole::ROLE_SUPER_ADMIN])) {
            return true;
        }

        /** @var Order $order */
        $order = $subject;

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($order, $user);
        }

        throw new HttpException(403, 'Доступ запрещен');
    }

    private function canView(Order $order, User $user)
    {
        return $user === $order->getUserId();
    }
}