<?php
/**
 * @package    Zenomania\CoreBundle\Event\Processor
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */

namespace Zenomania\CoreBundle\Event\Processor;

use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Zenomania\CoreBundle\Service\Club;

class PhotoUploadProcessor implements ProcessorInterface
{
    /**
     * @var Client
     */
    protected $client;
    /**
     * @var Club
     */
    private $service;

    public function __construct(Club $service)
    {
        $this->client = new Client();
        $this->service = $service;
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

        $tmpPath = tempnam(sys_get_temp_dir(), 'upload');
        $tmp = fopen($tmpPath, 'w');
        fwrite($tmp, $content);

        $stream = stream_get_meta_data($tmp);

        $file = new File($stream['uri']);

        // @save content
        $club = $this->getService()->findById($data['id']);
        $club->setLogoImg($file);
        $this->getService()->save($club);
    }

    /**
     * @return Club
     */
    public function getService(): Club
    {
        return $this->service;
    }
}
