<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 20.11.17
 * Time: 11:47
 */

namespace Zenomania\CoreBundle\Service\Upload;


class UploadClubPhoto extends UploadPhoto
{
    public function getUploadDirectory()
    {
        return $this->getContainer()->getParameter('club_upload_photo_dir');
    }
}