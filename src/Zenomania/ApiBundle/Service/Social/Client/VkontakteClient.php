<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 07.09.17
 * Time: 16:04
 */

namespace Zenomania\ApiBundle\Service\Social\Client;

use Zenomania\ApiBundle\Form\Model\ProfileSocialData;
use GuzzleHttp\Client;

class VkontakteClient implements ClientInterface
{
    protected $version = 5.68;

    protected $client;

    public function __construct()
    {
        $this->client = new Client(
            array('base_uri' => 'https://api.vk.com/method/')
        );
    }

    /**
     * Gets profile info from vkontakte
     *
     * @param ProfileSocialData $socialData
     * @return mixed
     * @throws ClientException
     */
    public function getProfile(ProfileSocialData $socialData)
    {
        $fields = array(
            'nickname',
            'contacts',
            'bdate',
            'city',
            'country',
            'sex'
        );
        $queryData = array(
            'fields' => implode(',', $fields),
            'access_token' => $socialData->getAccessToken(),
            'v' => $this->version,
        );
        $response = $this->client->request(
            'GET',
            'users.get',
            array('query' => $queryData)
        );
        $userInfo = \GuzzleHttp\json_decode($response->getBody()->getContents());
        if (isset($userInfo->response)) {
            $userInfo = array_shift($userInfo->response);
            return $userInfo;
        }
        throw new ClientException($userInfo->error->error_code, $userInfo->error->error_msg);
    }

    /**
     * Fetches news from vk wall in group
     *
     * @param int $ownerId
     * @param string $token
     * @param int $count
     * @param string $filter
     * @return mixed
     * @throws ClientException
     */
    public function getNews(int $ownerId, string $token, int $count, string $filter)
    {
        $queryData = array(
            'v' => $this->version,
            'owner_id' => $ownerId,
            'count' => $count,
            'filter' => $filter,
            'access_token' => $token,
            'offset' => 0
        );
        $response = $this->client->request(
            'GET',
            'wall.get',
            array('query' => $queryData)
        );

        $news = \GuzzleHttp\json_decode($response->getBody()->getContents());
        if (isset($news->response)) {
            $news = $news->response->items;
            return $news;
        }
        throw new ClientException($news->error->error_code, $news->error->error_msg);
    }
}