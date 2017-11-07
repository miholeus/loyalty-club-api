<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 02.11.17
 * Time: 14:36
 */

namespace Zenomania\CoreBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Zenomania\CoreBundle\Entity\OrderStatus;
use Symfony\Component\HttpFoundation\Request;

class OrderStatusController extends Controller
{

    /**
     * Lists all orderStatus entities.
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $orderStatuses = $em->getRepository('ZenomaniaCoreBundle:OrderStatus')->findAll();

        return $this->render('ZenomaniaCoreBundle:orderstatus:index.html.twig', array(
            'orderStatuses' => $orderStatuses,
        ));
    }

    /**
     * Creates a new orderStatus entity.
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $orderStatus = new OrderStatus();
        $form = $this->createForm('Zenomania\CoreBundle\Form\OrderStatusType', $orderStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($orderStatus);
            $em->flush();

            return $this->redirectToRoute('order_status_show', array('id' => $orderStatus->getId()));
        }

        return $this->render('ZenomaniaCoreBundle:orderstatus:new.html.twig', array(
            'orderStatuses' => $orderStatus,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a orderStatus entity.
     * @param OrderStatus $orderStatus
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(OrderStatus $orderStatus)
    {
        $deleteForm = $this->createDeleteForm($orderStatus);

        return $this->render('ZenomaniaCoreBundle:orderstatus:show.html.twig', array(
            'orderStatus' => $orderStatus,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing orderStatus entity.
     * @param Request $request
     * @param OrderStatus $orderStatus
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, OrderStatus $orderStatus)
    {
        $deleteForm = $this->createDeleteForm($orderStatus);
        $editForm = $this->createForm('Zenomania\CoreBundle\Form\OrderStatusType', $orderStatus);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('order_status_edit', array('id' => $orderStatus->getId()));
        }

        return $this->render('ZenomaniaCoreBundle:orderstatus:edit.html.twig', array(
            'orderStatus' => $orderStatus,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a orderStatus entity.
     * @param Request $request
     * @param OrderStatus $orderStatus
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, OrderStatus $orderStatus)
    {
        $form = $this->createDeleteForm($orderStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($orderStatus);
            $em->flush();
        }

        return $this->redirectToRoute('order_status_index');
    }

    /**
     * Creates a form to delete a orderStatus entity.
     *
     * @param OrderStatus $orderStatus The orderStatus entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(OrderStatus $orderStatus)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('order_status_delete', array('id' => $orderStatus->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}