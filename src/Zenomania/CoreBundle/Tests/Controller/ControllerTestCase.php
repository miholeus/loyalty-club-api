<?php

namespace Zenomania\CoreBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ControllerTestCase extends WebTestCase
{
    const TEST_USER_LOGIN = 'demo';
    const TEST_USER_PASSWORD = 'demo';

    /** @var  Container */
    protected $container;
    /** @var  Client */
    protected $client;

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    protected function setUp()
    {
        static::bootKernel();
        $this->container = static::$kernel->getContainer();
        $this->client = self::createClient([],
            [
                'PHP_AUTH_USER' => static::TEST_USER_LOGIN,
                'PHP_AUTH_PW' => static::TEST_USER_PASSWORD,
            ]
        );
    }

    protected static function createClient(array $options = [], array $server = [])
    {
        /** @var Client $client */
        $client = static::$kernel->getContainer()->get('test.client');
        $client->setServerParameters($server);

        return $client;
    }

    protected function get($service)
    {
        return $this->container->get($service);
    }

    protected function getEntityManager()
    {
        return $this->get('doctrine.orm.default_entity_manager');
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }
}
