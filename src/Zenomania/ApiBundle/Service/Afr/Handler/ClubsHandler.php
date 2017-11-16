<?php
/**
 * @package    Zenomania\ApiBundle\Service\Afr\Handler
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service\Afr\Handler;

use Monolog\Logger;

class ClubsHandler
{
    /**
     * @var Logger
     */
    private $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function handle(array $data)
    {
        // @todo handle data
    }
    /**
     * @return Logger
     */
    public function getLogger(): Logger
    {
        return $this->logger;
    }
}