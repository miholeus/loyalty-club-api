<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 05.09.17
 * Time: 9:47
 */

namespace Zenomania\ApiBundle\Service\Social;

use Zenomania\ApiBundle\Form\Model\ProfileSocialData;
use Zenomania\ApiBundle\Service\Social\Client\ClientInterface;
use Zenomania\CoreBundle\Entity\SocialAccount;

class Vkontakte implements SocialInterface
{
    public function getName()
    {
        return 'vk';
    }

    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Get social account by profile data
     *
     * @param ProfileSocialData $socialData
     * @return SocialAccount
     */
    public function getUserInfo(ProfileSocialData $socialData): SocialAccount
    {
        $data = $this->getClient()->getProfile($socialData);

        $socialAccount = new SocialAccount();
        $socialAccount->setNetwork($this->getName());
        $socialAccount->setAccessToken($socialData->getAccessToken());
        $socialAccount->setOuterId($socialData->getUserId());
        $socialAccount->setEmail($socialData->getEmail());
        $socialAccount->setBdate(new \DateTime($data->bdate));
        $socialAccount->setFirstName($data->first_name);
        $socialAccount->setLastName($data->last_name);
        $socialAccount->setSex($data->sex);
        $socialAccount->setCountry($data->country->id);
        $socialAccount->setCity($data->city->id);
        if (isset($data->mobile_phone)) {
            $socialAccount->setMobilePhone($data->mobile_phone);
        }

        return $socialAccount;
    }

    /**
     * Get access url
     *
     * @param $redirectUrl
     * @param $clientId
     * @return string
     */
    public function getAccess($redirectUrl, $clientId)
    {
        $url = 'http://oauth.vk.com/authorize';
        $token = 'token';
        $scope = [
            'offline',
            'email',
            'wall'
        ];

        $params = [
            'client_id' => $clientId,
            'redirect_uri' => $redirectUrl,
            'scope' => implode(',', $scope),
            'response_type' => $token,
        ];
        $link = $url . '?' . urldecode(http_build_query($params));
        return $link;
    }

    /**
     * @return ClientInterface
     */
    public function getClient(): ClientInterface
    {
        return $this->client;
    }
}