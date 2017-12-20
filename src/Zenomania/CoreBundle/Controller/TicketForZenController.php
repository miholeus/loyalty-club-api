<?php

namespace Zenomania\CoreBundle\Controller;

use Symfony\Component\Form\FormError;
use Zenomania\CoreBundle\Entity\TicketForZen;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Ticketforzen controller.
 *
 */
class TicketForZenController extends Controller
{
    /**
     * Lists all ticketForZen entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ticketForZens = $em->getRepository('ZenomaniaCoreBundle:TicketForZen')->findAll();

        return $this->render('ZenomaniaCoreBundle:ticketforzen:index.html.twig', array(
            'ticketForZens' => $ticketForZens,
        ));
    }

    /**
     * Creates a new ticketForZen entity.
     *
     */
    public function newAction(Request $request)
    {
        $ticketForZen = new Ticketforzen();
        $form = $this->createForm('Zenomania\CoreBundle\Form\TicketForZenType', $ticketForZen);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $service = $this->get('ticketforzen.service');

            try {
                $service->save($ticketForZen);
                return $this->redirectToRoute('ticketforzen_show', array('id' => $ticketForZen->getId()));
            } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
                $form->addError(new FormError($e->getMessage()));
            }
        }

        return $this->render('ZenomaniaCoreBundle:ticketforzen:new.html.twig', array(
            'ticketForZen' => $ticketForZen,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ticketForZen entity.
     *
     */
    public function showAction(TicketForZen $ticketForZen)
    {
        $deleteForm = $this->createDeleteForm($ticketForZen);

        return $this->render('ZenomaniaCoreBundle:ticketforzen:show.html.twig', array(
            'ticketForZen' => $ticketForZen,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ticketForZen entity.
     *
     */
    public function editAction(Request $request, TicketForZen $ticketForZen)
    {
        $deleteForm = $this->createDeleteForm($ticketForZen);
        $editForm = $this->createForm('Zenomania\CoreBundle\Form\TicketForZenType', $ticketForZen);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $service = $this->get('ticketforzen.service');

            try {
                $service->save($ticketForZen);
                return $this->redirectToRoute('ticketforzen_edit', array('id' => $ticketForZen->getId()));
            } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
                $editForm->addError(new FormError($e->getMessage()));
            }
        }

        return $this->render('ZenomaniaCoreBundle:ticketforzen:edit.html.twig', array(
            'ticketForZen' => $ticketForZen,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ticketForZen entity.
     *
     */
    public function deleteAction(Request $request, TicketForZen $ticketForZen)
    {
        $form = $this->createDeleteForm($ticketForZen);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ticketForZen);
            $em->flush();
        }

        return $this->redirectToRoute('ticketforzen_index');
    }

    /**
     * Creates a form to delete a ticketForZen entity.
     *
     * @param TicketForZen $ticketForZen The ticketForZen entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TicketForZen $ticketForZen)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ticketforzen_delete', array('id' => $ticketForZen->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
