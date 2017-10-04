<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 29.09.17
 * Time: 14:38
 */

namespace Zenomania\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Zenomania\CoreBundle\Entity\Badge;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;

class BadgeController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $badges = $em->getRepository('ZenomaniaCoreBundle:Badge')->findAll();

        return $this->render('ZenomaniaCoreBundle:badge:index.html.twig', array(
            'badges' => $badges,
        ));
    }

    /**
     * Creates a new badge entity.
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $badge = new Badge();
        /** @var Form $form */
        $form = $this->createForm('Zenomania\CoreBundle\Form\BadgeType', $badge);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $service = $this->get('badge.service');

            try {
                $service->save($badge);
                return $this->redirectToRoute('badge_show', array('id' => $badge->getId()));
            } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
                $form->addError(new FormError($e->getMessage()));
            }
        }

        return $this->render('ZenomaniaCoreBundle:badge:new.html.twig', array(
            'badge' => $badge,
            'form' => $form->createView(),
        ));
    }

    /**
     * @param Badge $badge
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Badge $badge)
    {
        $deleteForm = $this->createDeleteForm($badge);

        return $this->render('ZenomaniaCoreBundle:badge:show.html.twig', array(
            'badge' => $badge,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing badge entity.
     * @param Request $request
     * @param Badge $badge
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Badge $badge)
    {
        $deleteForm = $this->createDeleteForm($badge);
        /** @var Form $form */
        $editForm = $this->createForm('Zenomania\CoreBundle\Form\BadgeType', $badge);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $service = $this->get('badge.service');

            try {
                $service->save($badge);
                return $this->redirectToRoute('badge_edit', array('id' => $badge->getId()));
            } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
                $form->addError(new FormError($e->getMessage()));
            }
        }

        return $this->render('ZenomaniaCoreBundle:badge:edit.html.twig', array(
            'badge' => $badge,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a badge entity.
     * @param Request $request
     * @param Badge $badge
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Badge $badge)
    {
        $form = $this->createDeleteForm($badge);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($badge);
            $em->flush();
        }
        return $this->redirectToRoute('badge_index');

    }

    /**
     * Creates a form to delete a badge entity.
     *
     * @param Badge $badge The badge entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Badge $badge)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('badge_delete', array('id' => $badge->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}