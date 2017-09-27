<?php

namespace Zenomania\CoreBundle\Controller;

use Zenomania\CoreBundle\Entity\PromoCoupon;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Promocoupon controller.
 *
 */
class PromoCouponController extends Controller
{
    /**
     * Lists all promoCoupon entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $promoCoupons = $em->getRepository('ZenomaniaCoreBundle:PromoCoupon')->findAll();

        return $this->render('ZenomaniaCoreBundle:promocoupon:index.html.twig', array(
            'promoCoupons' => $promoCoupons,
        ));
    }

    /**
     * Creates a new promoCoupon entity.
     *
     */
    public function newAction(Request $request)
    {
        $promoCoupon = new Promocoupon();
        $form = $this->createForm('Zenomania\CoreBundle\Form\PromoCouponType', $promoCoupon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($promoCoupon);
            $em->flush();

            return $this->redirectToRoute('promocoupon_show', array('id' => $promoCoupon->getId()));
        }

        return $this->render('ZenomaniaCoreBundle:promocoupon:new.html.twig', array(
            'promoCoupon' => $promoCoupon,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a promoCoupon entity.
     *
     */
    public function showAction(PromoCoupon $promoCoupon)
    {
        $deleteForm = $this->createDeleteForm($promoCoupon);

        return $this->render('ZenomaniaCoreBundle:promocoupon:show.html.twig', array(
            'promoCoupon' => $promoCoupon,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing promoCoupon entity.
     *
     */
    public function editAction(Request $request, PromoCoupon $promoCoupon)
    {
        $deleteForm = $this->createDeleteForm($promoCoupon);
        $editForm = $this->createForm('Zenomania\CoreBundle\Form\PromoCouponType', $promoCoupon);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('promocoupon_edit', array('id' => $promoCoupon->getId()));
        }

        return $this->render('ZenomaniaCoreBundle:promocoupon:edit.html.twig', array(
            'promoCoupon' => $promoCoupon,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a promoCoupon entity.
     *
     */
    public function deleteAction(Request $request, PromoCoupon $promoCoupon)
    {
        $form = $this->createDeleteForm($promoCoupon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($promoCoupon);
            $em->flush();
        }

        return $this->redirectToRoute('promocoupon_index');
    }

    /**
     * Creates a form to delete a promoCoupon entity.
     *
     * @param PromoCoupon $promoCoupon The promoCoupon entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PromoCoupon $promoCoupon)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('promocoupon_delete', array('id' => $promoCoupon->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
