<?php
/**
 * @package    Zenomania\CoreBundle\DataFixtures\ORM
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */

namespace Zenomania\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Zenomania\CoreBundle\Entity\UserRole;

class LoadUserRoleData extends AbstractFixture
    implements OrderedFixtureInterface
{
    public function getOrder()
    {
        return 2;
    }

    public function load(ObjectManager $manager)
    {
        $data = [
            UserRole::ROLE_USER => 'Пользователь',
            UserRole::ROLE_ADMIN => 'Администратор',
            UserRole::ROLE_SUPER_ADMIN => 'Суперадминистратор'
        ];
        $roleAdmin = null;
        $roleUser = null;

        foreach ($data as $code => $name) {
            $role = new UserRole();
            $role->setName($code);
            $role->setTitle($name);
            if ($code == UserRole::ROLE_SUPER_ADMIN) {
                $roleAdmin = $role;
            } elseif ($code == UserRole::ROLE_USER) {
                $roleUser = $role;
            }

            $manager->persist($role);
        }

        $manager->flush();

        $this->addReference('role-super_admin', $roleAdmin);
        $this->addReference('role-user', $roleUser);
    }
}