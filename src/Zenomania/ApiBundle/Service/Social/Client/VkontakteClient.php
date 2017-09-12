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
     */
    public function getProfile(ProfileSocialData $socialData)
    {
        $queryData = array(
            'user_id' => $socialData->getUserId(),
            'access_token' => $socialData->getAccessToken(),
            'v' => $this->version,
        );
        $response = $this->client->request(
            'GET',
            'account.getProfileInfo',
            array('query' => $queryData)
        );
        $userInfo = \GuzzleHttp\json_decode($response->getBody()->getContents());
        if (isset($userInfo->response)) {
            $userInfo = $userInfo->response;
            return $userInfo;
        }
        return false;
    }
}