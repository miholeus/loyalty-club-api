<?php

namespace Zenomania\CoreBundle\Controller;

use Zenomania\CoreBundle\Entity\PointsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Pointstype controller.
 *
 */
class PointsTypeController extends Controller
{
    /**
     * Lists all pointsType entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pointsTypes = $em->getRepository('ZenomaniaCoreBundle:PointsType')->findAll();

        return $this->render('ZenomaniaCoreBundle:pointstype:index.html.twig', array(
            'pointsTypes' => $pointsTypes,
        ));
    }

    /**
     * Creates a new pointsType entity.
     *
     */
    public function newAction(Request $request)
    {
        $pointsType = new Pointstype();
        $form = $this->createForm('Zenomania\CoreBundle\Form\PointsTypeType', $pointsType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pointsType);
            $em->flush();

            return $this->redirectToRoute('pointstype_show', array('id' => $pointsType->getId()));
        }

        return $this->render('ZenomaniaCoreBundle:pointstype:new.html.twig', array(
            'pointsType' => $pointsType,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a pointsType entity.
     *
     */
    public function showAction(PointsType $pointsType)
    {
        $deleteForm = $this->createDeleteForm($pointsType);

        return $this->render('ZenomaniaCoreBundle:pointstype:show.html.twig', array(
            'pointsType' => $pointsType,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing pointsType entity.
     *
     */
    public function editAction(Request $request, PointsType $pointsType)
    {
        $deleteForm = $this->createDeleteForm($pointsType);
        $editForm = $this->createForm('Zenomania\CoreBundle\Form\PointsTypeType', $pointsType);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pointstype_edit', array('id' => $pointsType->getId()));
        }

        return $this->render('ZenomaniaCoreBundle:pointstype:edit.html.twig', array(
            'pointsType' => $pointsType,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a pointsType entity.
     *
     */
    public function deleteAction(Request $request, PointsType $pointsType)
    {
        $form = $this->createDeleteForm($pointsType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pointsType);
            $em->flush();
        }

        return $this->redirectToRoute('pointstype_index');
    }

    /**
     * Creates a form to delete a pointsType entity.
     *
     * @param PointsType $pointsType The pointsType entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PointsType $pointsType)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pointstype_delete', array('id' => $pointsType->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
