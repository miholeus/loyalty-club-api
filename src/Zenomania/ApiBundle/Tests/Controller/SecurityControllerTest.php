<?php

namespace Zenomania\ApiBundle\Tests\Controller;

class SecurityControllerTest extends ControllerTestCase
{
    protected $apiKeyAuthentication = true;

    public function testAuthenticationWithInvalidCredentialsFails()
    {
        $client = $this->getClient();

        $client->request('POST', '/api/v1/auth/logins', ['phone' => '71111111111', 'password' => 'test']);

        $response = $client->getResponse();
        $this->assert404($response);
        $this->assertException($response, 404);
    }

    public function testAuthenticationWithValidCredentials()
    {
        $client = $this->getClient();

        $client->request('POST', '/api/v1/auth/logins', ['phone' => '79999999999', 'password' => 'demo']);

        $response = $client->getResponse();
        $this->assertTrue($response->isSuccessful());
        $content = $this->getResponseContent($response);
        $this->assertArrayHasKey('token', $content['data']);
    }

    /**
     * Tests that blocked user cannot be authenticated
     */
    public function testAuthenticationByBlockedUserFails()
    {
        $factory = static::$kernel->getContainer()->get('test_entity_factory');

        /** @var \Zenomania\CoreBundle\Entity\User $user */
        $user = $factory->createUser();
        $password = 'test';

        /** @var \Zenomania\CoreBundle\Service\User $userService */
        $userService = static::$kernel->getContainer()->get('user.service');
        $userService->block($user);
        $userService->changePassword($user, $password);

        $client = $this->getClient();
        $client->request('POST', '/api/v1/auth/logins', ['phone' => $user->getPhone(), 'password' => $password]);

        $response = $client->getResponse();
        $this->assert403($response);
        $this->assertException($response, 403);
    }
}
