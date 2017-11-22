<?php
/**
 * @package    Zenomania\CoreBundle\Service\Upload
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */

namespace Zenomania\CoreBundle\Service\Upload;

use Symfony\Component\HttpFoundation\File\File;

interface UploadInterface
{
    /**
     * Upload file
     *
     * @param File $file
     * @param array $options
     * @return mixed
     */
    public function upload(File $file, $options = array());
}