<?php
/**
 * @package    Zenomania\CoreBundle\Repository
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Zenomania\CoreBundle\Entity\ApiToken;

class ApiTokenRepository extends EntityRepository
{
    /**
     * Saves token into repository
     *
     * @param ApiToken $token
     */
    public function save(ApiToken $token)
    {
        $this->_em->persist($token);
        $this->_em->flush($token);
    }
}