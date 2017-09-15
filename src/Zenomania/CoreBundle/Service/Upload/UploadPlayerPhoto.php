<?php
/**
 * @package    Zenomania\CoreBundle\Service\Upload
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\CoreBundle\Service\Upload;

class UploadPlayerPhoto extends UploadPhoto
{
    public function getUploadDirectory()
    {
        return $this->getContainer()->getParameter('player_upload_photo_dir');
    }
}