<?php

namespace Zenomania\CoreBundle\Controller;

use Zenomania\CoreBundle\Entity\Sport;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Sport controller.
 *
 */
class SportController extends Controller
{
    /**
     * Lists all sport entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sports = $em->getRepository('ZenomaniaCoreBundle:Sport')->findAll();

        return $this->render('ZenomaniaCoreBundle:sport:index.html.twig', array(
            'sports' => $sports,
        ));
    }

    /**
     * Creates a new sport entity.
     *
     */
    public function newAction(Request $request)
    {
        $sport = new Sport();
        $form = $this->createForm('Zenomania\CoreBundle\Form\SportType', $sport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($sport);
            $em->flush();

            return $this->redirectToRoute('sport_show', array('id' => $sport->getId()));
        }

        return $this->render('ZenomaniaCoreBundle:sport:new.html.twig', array(
            'sport' => $sport,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a sport entity.
     *
     */
    public function showAction(Sport $sport)
    {
        $deleteForm = $this->createDeleteForm($sport);

        return $this->render('ZenomaniaCoreBundle:sport:show.html.twig', array(
            'sport' => $sport,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing sport entity.
     *
     */
    public function editAction(Request $request, Sport $sport)
    {
        $deleteForm = $this->createDeleteForm($sport);
        $editForm = $this->createForm('Zenomania\CoreBundle\Form\SportType', $sport);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sport_edit', array('id' => $sport->getId()));
        }

        return $this->render('ZenomaniaCoreBundle:sport:edit.html.twig', array(
            'sport' => $sport,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a sport entity.
     *
     */
    public function deleteAction(Request $request, Sport $sport)
    {
        $form = $this->createDeleteForm($sport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($sport);
            $em->flush();
        }

        return $this->redirectToRoute('sport_index');
    }

    /**
     * Creates a form to delete a sport entity.
     *
     * @param Sport $sport The sport entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Sport $sport)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('sport_delete', array('id' => $sport->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
