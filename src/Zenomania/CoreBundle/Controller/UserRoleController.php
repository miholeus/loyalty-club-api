<?php

namespace Zenomania\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Zenomania\CoreBundle\Annotation\ActionBreadcrumb;
use Zenomania\CoreBundle\Entity\UserRole;

/**
 * UserRole controller.
 *
 */
class UserRoleController extends Controller
{
    /**
     * Lists all UserRole entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $userRoles = $em->getRepository('ZenomaniaCoreBundle:UserRole')->findAll();

        return $this->render('ZenomaniaCoreBundle:userrole:index.html.twig', array(
            'userRoles' => $userRoles,
        ));
    }

    /**
     * Creates a new UserRole entity.
     *
     * @ActionBreadcrumb("Create new")
     */
    public function newAction(Request $request)
    {
        $userRole = new UserRole();
        /** @var Form $form */
        $form = $this->createForm('Zenomania\CoreBundle\Form\UserRoleType', $userRole);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($userRole);
            $em->flush();

            return $this->redirectToRoute('user_role_show', array('id' => $userRole->getId()));
        }

        return $this->render('ZenomaniaCoreBundle:userrole:new.html.twig', array(
            'userRole' => $userRole,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a UserRole entity.
     *
     * @ActionBreadcrumb("Show: %s")
     */
    public function showAction(UserRole $userRole, Request $request)
    {
        $deleteForm = $this->createDeleteForm($userRole);
        $this->get('breadcrumbs.service')->renderBreadcrumb($request, $userRole->getName());

        return $this->render('ZenomaniaCoreBundle:userrole:show.html.twig', array(
            'userRole' => $userRole,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing UserRole entity.
     *
     * @ActionBreadcrumb("Edit: %s")
     */
    public function editAction(Request $request, UserRole $userRole)
    {
        $deleteForm = $this->createDeleteForm($userRole);
        /** @var Form $editForm */
        $editForm = $this->createForm('Zenomania\CoreBundle\Form\UserRoleType', $userRole);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($userRole);
            $em->flush();

            return $this->redirectToRoute('user_role_edit', array('id' => $userRole->getId()));
        }
        $this->get('breadcrumbs.service')->renderBreadcrumb($request, $userRole->getName());

        return $this->render('ZenomaniaCoreBundle:userrole:edit.html.twig', array(
            'userRole' => $userRole,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a UserRole entity.
     *
     */
    public function deleteAction(Request $request, UserRole $userRole)
    {
        $form = $this->createDeleteForm($userRole);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($userRole);
            $em->flush();
        }

        return $this->redirectToRoute('user_role_index');
    }

    /**
     * Creates a form to delete a UserRole entity.
     *
     * @param UserRole $userRole The UserRole entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(UserRole $userRole)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_role_delete', array('id' => $userRole->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
