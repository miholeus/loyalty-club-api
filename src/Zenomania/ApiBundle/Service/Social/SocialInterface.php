<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 05.09.17
 * Time: 9:44
 */

namespace Zenomania\ApiBundle\Service\Social;

use Zenomania\ApiBundle\Form\Model\ProfileSocialData;

interface SocialInterface
{
    /**
     * Returns social network name
     *
     * @return mixed
     */
    public function getName();

    /**
     * Gets user info from social network
     *
     * @param ProfileSocialData $socialData
     * @return mixed
     */
    public function getUserInfo(ProfileSocialData $socialData);
}