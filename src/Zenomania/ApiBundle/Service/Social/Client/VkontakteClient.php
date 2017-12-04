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
     * @param int $groupId
     * @return array
     * @throws ClientException
     */
    public function getReposts(News $post, int $groupId)
    {
        $reposts = array();
        $offset = 0;
        do {
            $queryData = [
                'owner_id' => $groupId,
                'post_id' => $post->getVkId(),
                'v' => $this->version,
                'offset' => $offset,
                'count' => 1
            ];
            $response = $this->client->request(
                'GET',
                'wall.getReposts',
                ['query' => $queryData]
            );
            sleep(1);
            $repost = \GuzzleHttp\json_decode($response->getBody()->getContents());

            if(isset($repost->error)){
                throw new ClientException($repost->error->error_code, $repost->error->error_msg);
            }

            $item = array_shift($repost->response->items);
            if($item){
                if(!array_key_exists($item->from_id, $reposts)){
                    $reposts[$item->from_id] = $item;
                }
            }
            $offset++;
        } while ($item);
        return $reposts;
    }

    /**
     * Получить массив из id аккаунтов пользователей, которые сделали репост
     *
     * @param News $post
     * @param int $groupId
     * @return mixed
     * @throws ClientException
     */
    public function getList(News $post, int $groupId)
    {
        $queryData = [
            'type' => 'post',
            'owner_id' => $groupId,
            'item_id' => $post->getVkId(),
            'filter' => 'copies',
            'friends_only' => 0,
            'v' => $this->version,
        ];
        $response = $this->client->request(
            'GET',
            'likes.getList',
            ['query' => $queryData]
        );
        $reposts = \GuzzleHttp\json_decode($response->getBody()->getContents());
        if (isset($reposts->response)) {
            return $reposts->response->items;
        }
        throw new ClientException($reposts->error->error_code, $reposts->error->error_msg);
    }

    /**
     * Создать репост переданной новости на стену пользователя по токену
     *
     * @param News $post
     * @param string $token
     * @param int $groupId
     * @return mixed
     * @throws ClientException
     */
    public function repost(News $post, string $token, int $groupId)
    {
        $queryData = [
            'object' => 'wall' . $groupId . '_' . $post->getVkId(),
            'access_token' => $token,
            'v' => $this->version,
        ];
        $response = $this->client->request(
            'GET',
            'wall.repost',
            ['query' => $queryData]
        );
        $reposts = \GuzzleHttp\json_decode($response->getBody()->getContents());
        if (isset($reposts->response)) {
            return $reposts->response->post_id;
        }
        throw new ClientException($reposts->error->error_code, $reposts->error->error_msg);
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