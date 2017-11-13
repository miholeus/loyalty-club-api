<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 29.09.17
 * Time: 16:12
 */

namespace Zenomania\CoreBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Zenomania\CoreBundle\Entity\Image;
use Zenomania\CoreBundle\Service\Upload\FilePathStrategy;
use Zenomania\CoreBundle\Service\Upload\UploadBadgePhoto;

class Badge extends UserAwareService
{
    /**
     * @var UploadBadgePhoto
     */
    protected $uploadService;
    /**
     * @var Images
     */
    protected $imageService;

    public function save(\Zenomania\CoreBundle\Entity\Badge $badge)
    {
        /**
         * Загружаем фото
         */
        $uploadedFiles = array();
        $uploadedFiles['Photo'] = $badge->getPhoto();
        $uploadedFiles['PhotoComplete'] = $badge->getPhotoComplete();

        foreach ($uploadedFiles as $property => $uploadedFile) {
            $setPhoto = 'set' . $property;
            if ($uploadedFile instanceof UploadedFile) {
                $badge->$setPhoto(null);
                $strategy = new FilePathStrategy();
                $strategy->setEntity($badge);
                $uploadService = $this->getUploadService();
                $uploadService->setUploadStrategy($strategy);
                $uploadedOriginalPathArray = $uploadService->upload($uploadedFile);

                // сохраняем фото в БД
                $imageService = $this->getImageService();
                /** @var Image $originalImage */
                $originalImage = $imageService->createImageFromFile($uploadedFile);
                $originalImage->setPath($uploadedOriginalPathArray['path']);
                $originalImage->setSize($uploadedFile->getClientSize());
                $imageService->save($originalImage);

                $badge->$setPhoto($uploadedOriginalPathArray['path']);
            }
        }

        $em = $this->getEntityManager();
        $em->persist($badge);
        $em->flush();
    }

    /**
     * @return UploadBadgePhoto
     */
    public function getUploadService(): UploadBadgePhoto
    {
        return $this->uploadService;
    }

    /**
     * @param UploadBadgePhoto $uploadService
     */
    public function setUploadService(UploadBadgePhoto $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    /**
     * @return Images
     */
    public function getImageService(): Images
    {
        return $this->imageService;
    }

    /**
     * @param Images $imageService
     */
    public function setImageService(Images $imageService)
    {
        $this->imageService = $imageService;
    }
}