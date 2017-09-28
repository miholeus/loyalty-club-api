<?php
/**
 * @package    Zenomania\ApiBundle\Request\Filter
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Request\Filter;

class ProfileStatsFilter extends AbstractFilter
{
    /**
     * Период за который нужно брать статистику
     *
     * @var string
     */
    public $period;
}