<?php
/**
 * @package    Zenomania\CoreBundle\Event\Processor
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */

namespace Zenomania\CoreBundle\Event\Processor;

interface ProcessorInterface
{
    /**
     * Process event
     *
     * @param mixed $event
     */
    public function process($event);
}
