<?php

namespace Zenomania\CoreBundle\Controller;

use Zenomania\CoreBundle\Entity\District;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * District controller.
 *
 */
class DistrictController extends Controller
{
    /**
     * Lists all district entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $districts = $em->getRepository('ZenomaniaCoreBundle:District')->findAll();

        return $this->render('ZenomaniaCoreBundle:district:index.html.twig', array(
            'districts' => $districts,
        ));
    }

    /**
     * Creates a new district entity.
     *
     */
    public function newAction(Request $request)
    {
        $district = new District();
        $form = $this->createForm('Zenomania\CoreBundle\Form\DistrictType', $district);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($district);
            $em->flush();

            return $this->redirectToRoute('district_show', array('id' => $district->getId()));
        }

        return $this->render('ZenomaniaCoreBundle:district:new.html.twig', array(
            'district' => $district,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a district entity.
     *
     */
    public function showAction(District $district)
    {
        $deleteForm = $this->createDeleteForm($district);

        return $this->render('ZenomaniaCoreBundle:district:show.html.twig', array(
            'district' => $district,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing district entity.
     *
     */
    public function editAction(Request $request, District $district)
    {
        $deleteForm = $this->createDeleteForm($district);
        $editForm = $this->createForm('Zenomania\CoreBundle\Form\DistrictType', $district);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('district_edit', array('id' => $district->getId()));
        }

        return $this->render('ZenomaniaCoreBundle:district:edit.html.twig', array(
            'district' => $district,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a district entity.
     *
     */
    public function deleteAction(Request $request, District $district)
    {
        $form = $this->createDeleteForm($district);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($district);
            $em->flush();
        }

        return $this->redirectToRoute('district_index');
    }

    /**
     * Creates a form to delete a district entity.
     *
     * @param District $district The district entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(District $district)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('district_delete', array('id' => $district->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
