<?php
/**
 * @package    Zenomania\ApiBundle\Service\Afr
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service\Afr;

use GuzzleHttp\Client;

class ApiClient
{
    /**
     * @var Client
     */
    protected $client;

    public function __construct(string $host)
    {
        $this->client = new Client([
            'base_uri' => $host
        ]);
    }

    /**
     * Authenticates user
     *
     * @param string $username
     * @param string $password
     * @return mixed
     * @throws AuthenticateFailedException
     */
    public function authenticate(string $username, string $password)
    {
        $data = [
            'username' => $username,
            'password' => $password
        ];

        $response = $this->client->request(
            'post',
            Endpoint::AUTH_URL,
            ['query' => $data]
        );

        $data = \GuzzleHttp\json_decode($response->getBody()->getContents());
        if (!empty($data['token'])) {
            return $data['token'];
        }
        throw new AuthenticateFailedException("Authentication failed");
    }
}