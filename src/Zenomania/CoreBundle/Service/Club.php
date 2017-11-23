<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 20.11.17
 * Time: 11:46
 */

namespace Zenomania\CoreBundle\Service;

use function GuzzleHttp\Psr7\mimetype_from_filename;
use Symfony\Component\HttpFoundation\File\File;
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
            $uploadedOriginalPathArray = $this->upload($club, $uploadedFile);

            $this->saveLogo($uploadedFile, $uploadedOriginalPathArray);
            $club->setLogoImg($uploadedOriginalPathArray['path']);
        } else if ($uploadedFile instanceof File) {
            $uploadedOriginalPathArray = $this->upload($club, $uploadedFile);

            $this->saveLogo($uploadedFile, $uploadedOriginalPathArray);
            $club->setLogoImg($uploadedOriginalPathArray['path']);
        }

        $em = $this->getEntityManager();
        $em->persist($club);
        $em->flush();
    }

    /**
     * Saves logo to storage
     *
     * @param File $uploadedFile
     * @param $uploadedOriginalPathArray
     */
    protected function saveLogo(File $uploadedFile, $uploadedOriginalPathArray)
    {
        $imageService = $this->getImageService();
        if ($uploadedFile instanceof UploadedFile) {
            /** @var Image $originalImage */
            $originalImage = $imageService->createImageFromUploadedFile($uploadedFile);
            $originalImage->setPath($uploadedOriginalPathArray['path']);
            $originalImage->setSize($uploadedFile->getClientSize());
        } else {
            $originalImage = $imageService->createImage();
            $originalImage->setName(basename($uploadedOriginalPathArray['path']));
            $originalImage->setPath($uploadedOriginalPathArray['path']);
            $originalImage->setSize(filesize($uploadedOriginalPathArray['full_path']));
            $originalImage->setMime(mimetype_from_filename($uploadedOriginalPathArray['full_path']));
        }
        $imageService->save($originalImage);
    }
    /**
     * Uploads file
     *
     * @param \Zenomania\CoreBundle\Entity\Club $club
     * @param File $uploadedFile
     * @return array
     */
    protected function upload(\Zenomania\CoreBundle\Entity\Club $club, File $uploadedFile)
    {
        $strategy = new FilePathStrategy();
        $strategy->setEntity($club);
        $uploadService = $this->getUploadService();
        $uploadService->setUploadStrategy($strategy);
        return $uploadService->upload($uploadedFile);
    }
    /**
     * Finds club by its identifier
     * 
     * @param int $id
     * @return \Zenomania\CoreBundle\Entity\Club
     */
    public function findById(int $id): \Zenomania\CoreBundle\Entity\Club
    {
        $em = $this->getEntityManager()->getRepository('ZenomaniaCoreBundle:Club');
        return $em->find($id);
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