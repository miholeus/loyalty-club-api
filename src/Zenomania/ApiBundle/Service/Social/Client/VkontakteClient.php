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
use Zenomania\CoreBundle\Entity\News;

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
     * Получить id всех пользователей сделавших репост заданного поста
     *
     * @param News $post
     * @return array
     * @throws ClientException
     */
    public function getReposts(News $post)
    {
        $queryData = [
            'owner_id' => '-32408054',
            'post_id' => $post->getVkId(),
            'v' => $this->version,
        ];
        $response = $this->client->request(
            'GET',
            'wall.getReposts',
            ['query' => $queryData]
        );
        $reposts = \GuzzleHttp\json_decode($response->getBody()->getContents());
        if (isset($reposts->response)) {
            return $reposts->response->items;
        }
        throw new ClientException($reposts->error->error_code, $reposts->error->error_msg);
    }
}