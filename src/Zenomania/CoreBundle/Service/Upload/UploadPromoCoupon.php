<?php
/**
 * @package    Zenomania\CoreBundle\Service\Upload
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\CoreBundle\Service\Upload;

class UploadPromoCoupon extends UploadFile
{
    public function getUploadDirectory()
    {
        return $this->getContainer()->getParameter('upload_promo_coupon_dir');
    }

    /**
     * Get upload directory path
     *
     * @return string
     */
    public function getUploadPath()
    {
        if (null === $this->uploadPath) {
            return $this->getUploadDirectory();
        }
        return $this->uploadPath;
    }
}