<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 31.10.17
 * Time: 19:07
 */

namespace Zenomania\CoreBundle\Service\Upload;


class UploadProductPhoto extends UploadPhoto
{
    public function getUploadDirectory()
    {
        return $this->getContainer()->getParameter('product_upload_photo_dir');
    }
}