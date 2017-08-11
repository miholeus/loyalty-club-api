<?php

namespace Zenomania\CoreBundle\Controller;

use Zenomania\CoreBundle\Entity\Education;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Education controller.
 *
 */
class EducationController extends Controller
{
    /**
     * Lists all education entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $educations = $em->getRepository('ZenomaniaCoreBundle:Education')->findAll();

        return $this->render('ZenomaniaCoreBundle:education:index.html.twig', array(
            'educations' => $educations,
        ));
    }

    /**
     * Creates a new education entity.
     *
     */
    public function newAction(Request $request)
    {
        $education = new Education();
        $form = $this->createForm('Zenomania\CoreBundle\Form\EducationType', $education);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($education);
            $em->flush();

            return $this->redirectToRoute('education_show', array('id' => $education->getId()));
        }

        return $this->render('ZenomaniaCoreBundle:education:new.html.twig', array(
            'education' => $education,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a education entity.
     *
     */
    public function showAction(Education $education)
    {
        $deleteForm = $this->createDeleteForm($education);

        return $this->render('ZenomaniaCoreBundle:education:show.html.twig', array(
            'education' => $education,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing education entity.
     *
     */
    public function editAction(Request $request, Education $education)
    {
        $deleteForm = $this->createDeleteForm($education);
        $editForm = $this->createForm('Zenomania\CoreBundle\Form\EducationType', $education);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('education_edit', array('id' => $education->getId()));
        }

        return $this->render('ZenomaniaCoreBundle:education:edit.html.twig', array(
            'education' => $education,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a education entity.
     *
     */
    public function deleteAction(Request $request, Education $education)
    {
        $form = $this->createDeleteForm($education);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($education);
            $em->flush();
        }

        return $this->redirectToRoute('education_index');
    }

    /**
     * Creates a form to delete a education entity.
     *
     * @param Education $education The education entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Education $education)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('education_delete', array('id' => $education->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
