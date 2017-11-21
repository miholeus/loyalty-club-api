<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 20.11.17
 * Time: 11:46
 */

namespace Zenomania\CoreBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Zenomania\CoreBundle\Entity\Image;
use Zenomania\CoreBundle\Service\Upload\FilePathStrategy;
use Zenomania\CoreBundle\Service\Upload\UploadClubPhoto;

class Club extends UserAwareService
{
    /**
     * @var UploadClubPhoto
     */
    protected $uploadService;
    /**
     * @var Images
     */
    protected $imageService;

    public function save(\Zenomania\CoreBundle\Entity\Club $club)
    {
        /**
         * Загружаем фото
         */
        $uploadedFile = $club->getLogoImg();

        if ($uploadedFile instanceof UploadedFile) {
            $strategy = new FilePathStrategy();
            $strategy->setEntity($club);
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

            $club->setLogoImg($uploadedOriginalPathArray['path']);
        }

        $em = $this->getEntityManager();
        $em->persist($club);
        $em->flush();
    }

    /**
     * @return UploadClubPhoto
     */
    public function getUploadService(): UploadClubPhoto
    {
        return $this->uploadService;
    }

    /**
     * @param UploadClubPhoto $uploadService
     */
    public function setUploadService(UploadClubPhoto $uploadService)
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