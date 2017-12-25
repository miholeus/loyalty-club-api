<?php
/**
 * @package    Zenomania\ApiBundle\Service\Afr\Filter
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */


namespace Zenomania\ApiBundle\Service\Afr\Filter;


use Zenomania\ApiBundle\Request\Filter\AbstractFilter;

class SubscriptionFilter extends AbstractFilter
{
    protected $page = 1;

    protected $clubId;

    public function getRequest()
    {
        return [
            'page' => $this->page ?? 1
        ];
    }

    public function getClubId(): int
    {
        return $this->clubId;
    }
}