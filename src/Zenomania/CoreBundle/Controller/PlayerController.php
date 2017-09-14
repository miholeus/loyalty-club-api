<?php

namespace Zenomania\CoreBundle\Controller;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Zenomania\CoreBundle\Entity\Image;
use Zenomania\CoreBundle\Entity\Player;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Zenomania\CoreBundle\Service\Images;
use Zenomania\CoreBundle\Service\Upload\FilePathStrategy;
use Zenomania\CoreBundle\Service\UploadProfilePhoto;

/**
 * Player controller.
 *
 */
class PlayerController extends Controller
{
    /**
     * Lists all player entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $players = $em->getRepository('ZenomaniaCoreBundle:Player')->findAll();

        return $this->render('ZenomaniaCoreBundle:player:index.html.twig', array(
            'players' => $players,
        ));
    }

    /**
     * Creates a new player entity.
     *
     */
    public function newAction(Request $request)
    {
        $player = new Player();
        $form = $this->createForm('Zenomania\CoreBundle\Form\PlayerType', $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($player);
            $em->flush();

            return $this->redirectToRoute('player_show', array('id' => $player->getId()));
        }

        return $this->render('ZenomaniaCoreBundle:player:new.html.twig', array(
            'player' => $player,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a player entity.
     *
     */
    public function showAction(Player $player)
    {
        $deleteForm = $this->createDeleteForm($player);

        return $this->render('ZenomaniaCoreBundle:player:show.html.twig', array(
            'player' => $player,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing player entity.
     *
     */
    public function editAction(Request $request, Player $player)
    {
        $deleteForm = $this->createDeleteForm($player);
        $photo = $player->getPhoto();

        /** @var Form $editForm */
        $editForm = $this->createForm('Zenomania\CoreBundle\Form\PlayerType', $player);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            /**
             * Загружаем фото
             */
            $uploadedFile = $player->getPhoto();

            if ($uploadedFile instanceof UploadedFile) {
                $player->setPhoto(null);
                $strategy = new FilePathStrategy();
                $strategy->setEntity($player);
                /** @var UploadProfilePhoto $uploadService */
                $uploadService = $this->get('file.upload_profile_photo');
                $uploadService->setUploadStrategy($strategy);
                $uploadedOriginalPathArray = $uploadService->upload($uploadedFile);

                // сохраняем фото в БД
                /** @var Images $imageService */
                $imageService = $this->get('images.service');
                /** @var Image $originalImage */
                $originalImage = $imageService->createImageFromFile($uploadedFile);
                $originalImage->setPath($uploadedOriginalPathArray['path']);
                $originalImage->setSize($uploadedFile->getClientSize());
                $imageService->save($originalImage);

                $player->setPhoto(new File($uploadedOriginalPathArray['full_path']));
            } else {
                $player->setPhoto($photo);// restore avatar

                $rootDirectory = $this->getParameter('upload_dir');

                $photo = $player->getPhoto();
                $photo = str_replace($rootDirectory, '', $photo);
                $player->setPhoto($photo);
            }

            try {
                $this->getDoctrine()->getManager()->flush();
                return $this->redirectToRoute('player_edit', array('id' => $player->getId()));
            } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
                $editForm->addError(new FormError($e->getMessage()));
            }
        }

        return $this->render('ZenomaniaCoreBundle:player:edit.html.twig', array(
            'player' => $player,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a player entity.
     *
     */
    public function deleteAction(Request $request, Player $player)
    {
        $form = $this->createDeleteForm($player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($player);
            $em->flush();
        }

        return $this->redirectToRoute('player_index');
    }

    /**
     * Creates a form to delete a player entity.
     *
     * @param Player $player The player entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Player $player)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('player_delete', array('id' => $player->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
