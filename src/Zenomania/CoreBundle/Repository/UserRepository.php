<?php

namespace Zenomania\CoreBundle\Repository;

use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Zenomania\CoreBundle\Entity\Actor;
use Zenomania\CoreBundle\Entity\Person;
use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Entity\UserReferralCode;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository implements UserLoaderInterface
{
    /**
     * Loads user by username
     * It is used by firewall security component
     *
     * @param string $username
     * @return User
     */
    public function loadUserByUsername($username)
    {
        /** @var User $user */
        $user = $this->createQueryBuilder('u')
            ->where('u.login = :username')
            ->setParameter('username', $username)
            ->getQuery()
            ->getOneOrNullResult();

        return $user;
    }

    /**
     * Возвращает список пользователей по части имени
     *
     * @param string $firstName Часть имени пользователя
     *
     * @return User[]
     */
    public function findUser($firstName)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('u')
            ->from('ZenomaniaCoreBundle:User', 'u')
            ->where('LOWER (u.firstname) LIKE LOWER(:query)')
            ->setParameter('query', '%' . $firstName . '%');
        $query = $qb->getQuery();
        $userList = $query->getResult();
        return $userList;
    }

    /**
     * Get user status
     *
     * @param $code
     * @return null|object|\Zenomania\CoreBundle\Entity\UserStatus
     */
    public function getStatus($code)
    {
        $repository = $this->getEntityManager()->getRepository('ZenomaniaCoreBundle:UserStatus');
        return $repository->findOneBy(['code' => $code]);
    }

    /**
     * Get user role
     *
     * @param $code
     * @return null|object|\Zenomania\CoreBundle\Entity\UserRole
     */
    public function getRole($code)
    {
        $repository = $this->getEntityManager()->getRepository('ZenomaniaCoreBundle:UserRole');
        return $repository->findOneBy(['name' => $code]);
    }

    /**
     * Finds user by recovery code
     *
     * @param $code
     * @return \Zenomania\CoreBundle\Entity\User
     */
    public function findOneByNotNullRecoveryCode($code)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('u')
            ->from('ZenomaniaCoreBundle:User', 'u')
            ->where('u.verifyEmailUuid = :code')
            ->setParameter('code', $code)
            ->getQuery();
        return $query->getSingleResult();
    }

    /**
     * @param \Doctrine\ORM\QueryBuilder $qb
     * @param string $alias - table alias
     * @return mixed
     */
    public function setOrderByFullName(\Doctrine\ORM\QueryBuilder $qb, $alias)
    {
        $qb->addOrderBy($alias.'.lastname');
        $qb->addOrderBy($alias.'.firstname');
        $qb->addOrderBy($alias.'.middlename');
        return $qb;
    }

    /**
     * Finds by name
     *
     * @param $name
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getQueryByName($name)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder = $qb->select('u')->from(User::class, 'u');
        return self::addQueryNameSearch($queryBuilder, $name);
    }

    /**
     * Adds where clauses to QueryBuilder for user search by name
     *
     * @param QueryBuilder $queryBuilder
     * @param $name
     * @return QueryBuilder
     */
    public static function addQueryNameSearch(QueryBuilder $queryBuilder, $name, $userAlias = 'u')
    {
        if (!$name) {
            return $queryBuilder;
        }
        /** @var array $queryData */
        $queryData = array_map(
            function ($string) {
                return mb_strtolower(trim($string), 'utf-8');
            },
            explode(' ', $name)
        );
        if (1 === count($queryData)) {
            return $queryBuilder->andWhere(
                "LOWER($userAlias.firstname) LIKE :name OR LOWER($userAlias.lastname) LIKE :name"
            )
                ->setParameter('name', "{$queryData[0]}%");
        }
        return $queryBuilder->andWhere(
            "LOWER($userAlias.firstname) LIKE :name2 AND LOWER($userAlias.lastname) LIKE :name1"
        )->orWhere(
            "LOWER($userAlias.firstname) LIKE :name1 AND LOWER($userAlias.lastname) LIKE :name2"
        )
            ->setParameter('name1', "{$queryData[0]}%")
            ->setParameter('name2', "{$queryData[1]}%");

    }

    /**
     * Проверяет есть ли пользователь по заданному логину, телефону, email
     *
     * @param string $login
     * @param string $phone
     * @param string $email
     * @return bool
     */
    public function existsUserByLoginOrPhone($login, $phone, $email)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('u')
            ->from('ZenomaniaCoreBundle:User', 'u')
            ->where('u.login = :login OR u.phone = :phone ')
            ->setParameter('login', $login)
            ->setParameter('phone', $phone);

        if (!empty($email)) {
            $qb->orWhere('u.email = :email')
                ->setParameter('email', $email);
        }

        $query = $qb->getQuery();
        $userList = $query->getResult();

        if (empty($userList)) {
            return false;
        }

        return true;
    }

    public function save(User $user)
    {
        $this->_em->persist($user);
        $this->_em->flush();
    }
}
