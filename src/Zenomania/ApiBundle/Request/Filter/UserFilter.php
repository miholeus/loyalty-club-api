<?php
/**
 * @package    Zenomania\ApiBundle\Request\Filter
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Request\Filter;

class UserFilter extends AbstractFilter
{
    /**
     * @var int
     */
    protected $offset = 0;

    /**
     * @var int
     */
    protected $limit = 10000;

    public $dateStart;

    public $dateEnd;

    public function getLimit()
    {
        return $this->limit;
    }
}