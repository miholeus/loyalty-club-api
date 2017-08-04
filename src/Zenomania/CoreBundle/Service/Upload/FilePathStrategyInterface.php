<?php
/**
 * @package    Zenomania\CoreBundle\Service\Upload
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */

namespace Zenomania\CoreBundle\Service\Upload;

interface FilePathStrategyInterface
{
    /**
     * Gets file path
     *
     * @return string
     */
    public function getFilePath();
}