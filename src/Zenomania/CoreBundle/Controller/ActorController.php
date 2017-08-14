<?php

namespace Zenomania\CoreBundle\Controller;

use Zenomania\CoreBundle\Entity\Actor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Actor controller.
 *
 */
class ActorController extends Controller
{
    /**
     * Lists all actor entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $actors = $em->getRepository('ZenomaniaCoreBundle:Actor')->findAll();

        return $this->render('ZenomaniaCoreBundle:actor:index.html.twig', array(
            'actors' => $actors,
        ));
    }

    /**
     * Creates a new actor entity.
     *
     */
    public function newAction(Request $request)
    {
        $actor = new Actor();
        $form = $this->createForm('Zenomania\CoreBundle\Form\ActorType', $actor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($actor);
            $em->flush();

            return $this->redirectToRoute('actor_show', array('id' => $actor->getId()));
        }

        return $this->render('ZenomaniaCoreBundle:actor:new.html.twig', array(
            'actor' => $actor,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a actor entity.
     *
     */
    public function showAction(Actor $actor)
    {
        $deleteForm = $this->createDeleteForm($actor);

        return $this->render('ZenomaniaCoreBundle:actor:show.html.twig', array(
            'actor' => $actor,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing actor entity.
     *
     */
    public function editAction(Request $request, Actor $actor)
    {
        $deleteForm = $this->createDeleteForm($actor);
        $editForm = $this->createForm('Zenomania\CoreBundle\Form\ActorType', $actor);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('actor_edit', array('id' => $actor->getId()));
        }

        return $this->render('ZenomaniaCoreBundle:actor:edit.html.twig', array(
            'actor' => $actor,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a actor entity.
     *
     */
    public function deleteAction(Request $request, Actor $actor)
    {
        $form = $this->createDeleteForm($actor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($actor);
            $em->flush();
        }

        return $this->redirectToRoute('actor_index');
    }

    /**
     * Creates a form to delete a actor entity.
     *
     * @param Actor $actor The actor entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Actor $actor)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('actor_delete', array('id' => $actor->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
