<?php
/**
 * @package    Zenomania\ApiBundle\Service\Transformer
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */

namespace Zenomania\ApiBundle\Service\Transformer;

/**
 * Manager that initializes scope manager
 */
class Manager
{
    public function __construct(ScopeManager $manager)
    {
        $this->manager = $manager;
    }
    /**
     * @var ScopeManager
     */
    protected $manager;

    /**
     * @return ScopeManager
     */
    public function getManager()
    {
        return $this->manager;
    }
}