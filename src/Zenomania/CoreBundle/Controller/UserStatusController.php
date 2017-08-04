<?php

namespace Zenomania\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Zenomania\CoreBundle\Annotation\ActionBreadcrumb;
use Zenomania\CoreBundle\Entity\UserStatus;

/**
 * UserStatus controller.
 *
 */
class UserStatusController extends Controller
{
    /**
     * Lists all UserStatus entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $userStatuses = $em->getRepository('ZenomaniaCoreBundle:UserStatus')->findAll();

        return $this->render('ZenomaniaCoreBundle:userstatus:index.html.twig', array(
            'userStatuses' => $userStatuses,
        ));
    }

    /**
     * Creates a new UserStatus entity.
     *
     * @ActionBreadcrumb("Create new")
     */
    public function newAction(Request $request)
    {
        $userStatus = new UserStatus();
        /** @var Form $form */
        $form = $this->createForm('Zenomania\CoreBundle\Form\UserStatusType', $userStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($userStatus);
            $em->flush();

            return $this->redirectToRoute('user_status_show', array('id' => $userStatus->getId()));
        }

        return $this->render('ZenomaniaCoreBundle:userstatus:new.html.twig', array(
            'userStatus' => $userStatus,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a UserStatus entity.
     *
     * @ActionBreadcrumb("Show: %s")
     */
    public function showAction(UserStatus $userStatus, Request $request)
    {
        $deleteForm = $this->createDeleteForm($userStatus);
        $this->get('breadcrumbs.service')->renderBreadcrumb($request, $userStatus->getName());

        return $this->render('ZenomaniaCoreBundle:userstatus:show.html.twig', array(
            'userStatus' => $userStatus,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing UserStatus entity.
     *
     * @ActionBreadcrumb("Edit: %s")
     */
    public function editAction(Request $request, UserStatus $userStatus)
    {
        /** @var Form $deleteForm */
        $deleteForm = $this->createDeleteForm($userStatus);
        /** @var Form $editForm */
        $editForm = $this->createForm('Zenomania\CoreBundle\Form\UserStatusType', $userStatus);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($userStatus);
            $em->flush();

            return $this->redirectToRoute('user_status_edit', array('id' => $userStatus->getId()));
        }
        $this->get('breadcrumbs.service')->renderBreadcrumb($request, $userStatus->getName());

        return $this->render('ZenomaniaCoreBundle:userstatus:edit.html.twig', array(
            'userStatus' => $userStatus,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a UserStatus entity.
     *
     */
    public function deleteAction(Request $request, UserStatus $userStatus)
    {
        $form = $this->createDeleteForm($userStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($userStatus);
            $em->flush();
        }

        return $this->redirectToRoute('user_status_index');
    }

    /**
     * Creates a form to delete a UserStatus entity.
     *
     * @param UserStatus $userStatus The UserStatus entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(UserStatus $userStatus)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_status_delete', array('id' => $userStatus->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
