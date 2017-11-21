<?php
/**
 * @package    Zenomania\CoreBundle\Event\Processor
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */

namespace Zenomania\CoreBundle\Event\Processor;

use GuzzleHttp\Client;

class PhotoUploadProcessor implements ProcessorInterface
{
    /**
     * @var Client
     */
    protected $client;
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * Process event
     *
     * @param mixed $event
     * @return bool
     */
    public function process($event)
    {
        $data = unserialize($event);
        $logo = $data['logo'];

        $response = $this->client->request(
            'GET',
            $logo
        );

        $content = $response->getBody()->getContents();

        // @save content
    }
}
