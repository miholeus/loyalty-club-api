<?php
/**
 * @package    Zenomania\ApiBundle\Service\Afr\Filter
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */


namespace Zenomania\ApiBundle\Service\Afr\Filter;


use Zenomania\ApiBundle\Request\Filter\AbstractFilter;

class ClubFilter extends AbstractFilter
{
    protected $sportId;

    public function getSportId(): int
    {
        return $this->sportId;
    }
}