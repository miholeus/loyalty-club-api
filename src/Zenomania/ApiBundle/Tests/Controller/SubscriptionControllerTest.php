<?php

namespace Zenomania\ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SubscriptionControllerTest extends WebTestCase
{
    public function testPostsubscriptionregistration()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/postSubscriptionRegistration');
    }

}
