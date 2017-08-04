<?php
/**
 * @package    Zenomania\CoreBundle\Service
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */

namespace Zenomania\CoreBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface IUpload
{
    /**
     * Upload file
     *
     * @param UploadedFile $file
     * @param array $options
     * @return mixed
     */
    public function upload(UploadedFile $file, $options = array());
}