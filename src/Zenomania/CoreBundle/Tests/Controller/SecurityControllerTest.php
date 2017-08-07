<?php
/**
 * @package    Zenomania\CoreBundle\Tests\Controller
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */

namespace Zenomania\CoreBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends WebTestCase
{
    public function testRegularUsersCannotAccessToTheBackend()
    {
        $this->markTestSkipped();

        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'john_user',
            'PHP_AUTH_PW'   => 'kitten',
        ));
        $client->request('GET', '/user');
        $this->assertEquals(Response::HTTP_FORBIDDEN, $client->getResponse()->getStatusCode());
    }
    public function testAdministratorUsersCanAccessToTheBackend()
    {
        $this->markTestSkipped();

        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'demo',
            'PHP_AUTH_PW'   => 'demo',
        ));
        $client->request('GET', '/user');
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }
}