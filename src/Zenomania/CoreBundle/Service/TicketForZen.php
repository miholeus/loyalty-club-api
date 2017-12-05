<?php
/**
 * @package    Zenomania\CoreBundle\Service
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\CoreBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Zenomania\CoreBundle\Entity\Image;
use Zenomania\CoreBundle\Service\Upload\FilePathStrategy;
use Zenomania\CoreBundle\Service\Upload\UploadPromoTicket;
use Symfony\Component\HttpFoundation\File\File;

/**
 * TicketForZen service
 */
class TicketForZen extends UserAwareService
{
    const DEFAULT_CLUB_ID = 9;
    /**
     * @var UploadPromoTicket
     */
    protected $uploadService;
    /**
     * @var Images
     */
    protected $imageService;

    public function save(\Zenomania\CoreBundle\Entity\TicketForZen $ticket)
    {
        /**
         * Загружаем билет
         */
        $uploadedFile = $ticket->getBarcode();

        if ($uploadedFile instanceof UploadedFile) {
            $ticket->setBarcode(null);
            $strategy = new FilePathStrategy();
            $strategy->setEntity($ticket);
            $uploadService = $this->getUploadService();
            $uploadService->setUploadStrategy($strategy);
            $uploadedOriginalPathArray = $uploadService->upload($uploadedFile);

            // сохраняем фото в БД
            $imageService = $this->getImageService();
            /** @var Image $originalImage */
            $originalImage = $imageService->createImageFromUploadedFile($uploadedFile);
            $originalImage->setPath($uploadedOriginalPathArray['path']);
            $originalImage->setSize($uploadedFile->getClientSize());
            $imageService->save($originalImage);

            $ticket->setBarcode($uploadedOriginalPathArray['path']);
        }

        $em = $this->getEntityManager();
        $em->persist($ticket);
        $em->flush();
    }

    /**
     * @return UploadPromoTicket
     */
    public function getUploadService(): UploadPromoTicket
    {
        return $this->uploadService;
    }

    /**
     * @param UploadPromoTicket $uploadService
     */
    public function setUploadService(UploadPromoTicket $uploadService)
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

    /**
     * Fetches active players for club
     *
     * @param integer $clubId
     * @return array|\Zenomania\CoreBundle\Entity\Player[]
     */
    public function getActivePlayers($clubId)
    {
        $repo = $this->getEntityManager()->getRepository('ZenomaniaCoreBundle:Player');
        return $repo->findBy(['isActive' => true, 'club' => $clubId]);
    }

    /**
     * Gets players by IDs
     *
     * @param array $ids
     * @param null $clubId
     * @return \Zenomania\CoreBundle\Entity\Player[]
     */
    public function getByIds($ids, $clubId = null)
    {
        $repo = $this->getEntityManager()->getRepository('ZenomaniaCoreBundle:Player');
        return $repo->findBy(
            [
                'id' => $ids,
                'isActive' => true,
                'club' => $clubId
            ]
        );
    }
}