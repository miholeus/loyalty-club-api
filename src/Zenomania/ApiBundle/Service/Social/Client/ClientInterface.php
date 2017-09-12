<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 07.09.17
 * Time: 16:05
 */

namespace Zenomania\ApiBundle\Service\Social\Client;

use Zenomania\ApiBundle\Form\Model\ProfileSocialData;

interface ClientInterface
{
    /**
     * Gets profile information
     *
     * @param ProfileSocialData $socialData
     * @return mixed
     */
    public function getProfile(ProfileSocialData $socialData);
}