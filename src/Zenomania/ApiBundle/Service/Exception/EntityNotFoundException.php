<?php
/**
 * @package    Zenomania\ApiBundle\Service\Exception
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service\Exception;

class EntityNotFoundException extends \Doctrine\ORM\EntityNotFoundException
{
    /**
     * @return EntityNotFoundException
     */
    public static function eventNotFound()
    {
        return new self("Событие не найдено");
    }
}