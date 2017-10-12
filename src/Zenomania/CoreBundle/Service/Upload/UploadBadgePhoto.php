<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 29.09.17
 * Time: 16:39
 */

namespace Zenomania\CoreBundle\Service\Upload;


class UploadBadgePhoto extends UploadPhoto
{
    public function getUploadDirectory()
    {
        return $this->getContainer()->getParameter('badge_upload_photo_dir');
    }
}