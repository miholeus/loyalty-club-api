<?php
/**
 * Created by PhpStorm.
 * User: igorvolkov
 * Date: 27.10.17
 * Time: 13:37
 */

namespace Zenomania\ApiBundle\Request\Filter;


use Zenomania\CoreBundle\Entity\User;

class BadgeFilter extends AbstractFilter
{
    /**
     * Период за который нужно брать статистику
     *
     * @var string
     */
    public $period = null;

    /**
     * @var User
     */
    public $user;

}