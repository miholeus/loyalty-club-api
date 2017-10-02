<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 02.10.17
 * Time: 11:03
 */

namespace Zenomania\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Zenomania\CoreBundle\Entity\BadgeType;

class BadgeTypeController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $badgeType = $em->getRepository('ZenomaniaCoreBundle:BadgeType')->findAll();

        return $this->render('ZenomaniaCoreBundle:badgetype:index.html.twig', array(
            'badgeTypes' => $badgeType,
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $badgeType = new BadgeType();
        /** @var Form $form */
        $form = $this->createForm('Zenomania\CoreBundle\Form\BadgeTypeType', $badgeType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($badgeType);
            $em->flush();

            return $this->redirectToRoute('badge_type_show', array('id' => $badgeType->getId()));
        }

        return $this->render('ZenomaniaCoreBundle:badgetype:new.html.twig', array(
            'badgeType' => $badgeType,
            'form' => $form->createView(),
        ));
    }

    /**
     * @param BadgeType $badgeType
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(BadgeType $badgeType)
    {
        $deleteForm = $this->createDeleteForm($badgeType);
        return $this->render('ZenomaniaCoreBundle:badgetype:show.html.twig', array(
            'badgeType' => $badgeType,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @param Request $request
     * @param BadgeType $badge
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, BadgeType $badge)
    {
        $form = $this->createDeleteForm($badge);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($badge);
            $em->flush();
        }
        return $this->redirectToRoute('badge_type_index');

    }

    /**
     * Displays a form to edit an existing badge type entity.
     * @param Request $request
     * @param BadgeType $badgeType
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, BadgeType $badgeType)
    {
        $deleteForm = $this->createDeleteForm($badgeType);
        /** @var Form $form */
        $editForm = $this->createForm('Zenomania\CoreBundle\Form\BadgeTypeType', $badgeType);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('badge_type_edit', array('id' => $badgeType->getId()));
        }

        return $this->render('ZenomaniaCoreBundle:badgetype:edit.html.twig', array(
            'badgeType' => $badgeType,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @param BadgeType $badgeType
     * @return Form|\Symfony\Component\Form\FormInterface
     */
    private function createDeleteForm(BadgeType $badgeType)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('badge_type_delete', array('id' => $badgeType->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}