<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 31.10.17
 * Time: 19:03
 */

namespace Zenomania\CoreBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Zenomania\CoreBundle\Entity\Image;
use Zenomania\CoreBundle\Service\Upload\FilePathStrategy;
use Zenomania\CoreBundle\Service\Upload\UploadProductPhoto;
use Zenomania\CoreBundle\Entity\Product;

class ProductService extends UserAwareService
{
    /**
     * @var UploadProductPhoto
     */
    protected $uploadService;
    /**
     * @var Images
     */
    protected $imageService;

    public function save(Product $product)
    {
        /**
         * Загружаем фото
         */
        $uploadedFile = $product->getPhoto();
        if ($uploadedFile instanceof UploadedFile) {
            $strategy = new FilePathStrategy();
            $strategy->setEntity($product);
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

            $product->setPhoto($uploadedOriginalPathArray['path']);
        }

        $em = $this->getEntityManager();
        $em->persist($product);
        $em->flush();
    }

    /**
     * @return UploadProductPhoto
     */
    public function getUploadService(): UploadProductPhoto
    {
        return $this->uploadService;
    }

    /**
     * @param UploadProductPhoto $uploadService
     */
    public function setUploadService(UploadProductPhoto $uploadService)
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