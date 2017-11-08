<?php
/**
 * @package    Zenomania\ApiBundle\Service\Afr
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Service\Afr;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Zenomania\ApiBundle\Service\Afr\Filter\EventFilter;

class ApiClient
{
    /**
     * Token name that is used for authentication with AFR service
     */
    const ACCESS_TOKEN_KEY = 'access-token';
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

        try {
            $response = $this->client->post(
                Endpoint::AUTH_URL,
                ['form_params' => $data, 'http_errors' => false]
            );
        } catch (ClientException $e) {
            throw new AuthenticateFailedException($e->getMessage(), 0, $e);
        }

        $data = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);

        if (!empty($data['token'])) {
            return $data['token'];
        } elseif (!empty($data['errors'])) {
            $errors = [];
            foreach ($data['errors'] as $err) {
                $errors[] = join(",", $err);
            }
            throw new AuthenticateFailedException(join("\n", $errors));
        }
        throw new AuthenticateFailedException("Authentication failed: " . $data['message']);
    }

    /**
     * Get matches from service
     *
     * @param \Zenomania\CoreBundle\Entity\ApiToken $token
     * @param EventFilter $filter
     * @return mixed
     */
    public function getEvents(\Zenomania\CoreBundle\Entity\ApiToken $token, EventFilter $filter)
    {
        try {
            $request = array_merge($filter->getRequest(), [
                self::ACCESS_TOKEN_KEY => $token->getToken()
            ]);

            $response = $this->client->get(
                strtr(Endpoint::MATCHES_URL, [':club' => $filter->getClubId()]),
                ['query' => $request, 'http_errors' => false]
            );
        } catch (ClientException $e) {
            throw new ApiException(500, $e->getMessage(), $e);
        }

        $data = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
        if (!empty($data['status']) && $data['status'] != 200) {
            throw ApiException::createException($data['status'], $data['message']);
        }

        return $data['data'];
    }
}