<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 02.11.17
 * Time: 15:12
 */

namespace Zenomania\CoreBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Zend\Validator\Date;
use Zenomania\CoreBundle\Entity\Order;
use Symfony\Component\HttpFoundation\Request;
use Zenomania\CoreBundle\Entity\OrderCart;
use Zenomania\CoreBundle\Entity\OrderDelivery;
use Zenomania\CoreBundle\Entity\OrderStatusHistory;
use Zenomania\CoreBundle\Repository\OrderRepository;

class OrderController extends Controller
{

    /**
     * Lists all order entities.
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $orders = $em->getRepository('ZenomaniaCoreBundle:Order')->findAll();
        return $this->render('ZenomaniaCoreBundle:order:index.html.twig', array(
            'orders' => $orders,
        ));
    }

    /**
     * Creates a new order entity.
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $orderDelivery = new OrderDelivery();
        $form = $this->createForm('Zenomania\CoreBundle\Form\DeliveryType', $orderDelivery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($orderDelivery);
            $em->flush();

            return $this->redirectToRoute('order_show', array('id' => $orderDelivery->getId()));
        }

        return $this->render('ZenomaniaCoreBundle:order:new.html.twig', array(
            'formDelivery' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a order entity.
     * @param Order $order
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Order $order)
    {
        $deleteForm = $this->createDeleteForm($order);

        $em = $this->getDoctrine()->getManager();

        $order = $em->getRepository('ZenomaniaCoreBundle:Order')->getOrder($order);

        return $this->render('ZenomaniaCoreBundle:order:show.html.twig', array(
            'order' => $order,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing order entity.
     * @param Request $request
     * @param Order $order
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Order $order)
    {
        $order->setUpdatedAt(new Date());
        $deleteForm = $this->createDeleteForm($order);
        $editForm = $this->createForm('Zenomania\CoreBundle\Form\OrderType', $order);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('order_edit', array('id' => $order->getId()));
        }

        return $this->render('ZenomaniaCoreBundle:order:edit.html.twig', array(
            'order' => $order,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a order entity.
     * @param Request $request
     * @param Order $order
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Order $order)
    {
        $form = $this->createDeleteForm($order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($order);
            $em->flush();
        }

        return $this->redirectToRoute('order_index');
    }

    /**
     * Creates a form to delete a order entity.
     *
     * @param Order $order The order entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Order $order)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('order_delete', array('id' => $order->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}