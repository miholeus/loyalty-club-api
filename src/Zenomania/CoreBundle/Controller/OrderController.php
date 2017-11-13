<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 02.11.17
 * Time: 15:12
 */

namespace Zenomania\CoreBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Zenomania\CoreBundle\Entity\Order;
use Symfony\Component\HttpFoundation\Request;
use Zenomania\CoreBundle\Entity\OrderCart;
use Zenomania\CoreBundle\Entity\OrderDelivery;
use Zenomania\CoreBundle\Entity\OrderStatusHistory;
use Zenomania\CoreBundle\Form\Model\Order as ModelOrder;

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
     * Finds and displays a order entity.
     * @param Order $order
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Order $order)
    {
        $deleteForm = $this->createDeleteForm($order);

        $service = $this->get('order.service');

        $data = $service->getOrderData($order);
        $data['orderDelivery'] = $data['orderDelivery'] ?? new OrderDelivery();

        return $this->render('ZenomaniaCoreBundle:order:show.html.twig', array(
            'order' => $order,
            'data' => $data,
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
        $deleteForm = $this->createDeleteForm($order);

        $service = $this->get('order.service');

        $data = $service->getOrderData($order);

        /** @var OrderDelivery $orderDelivery */
        $orderDelivery = $data['orderDelivery'];
        $orderDelivery = $orderDelivery ?? new OrderDelivery();

        $modelOrder = new ModelOrder();
        $orderStatusHistory = new OrderStatusHistory();
        $orderStatusHistory->setCreatedBy($this->getUser());

        /** @var \Zenomania\CoreBundle\Form\Model\Order $editForm */
        $editForm = $this->createEditForm($modelOrder, $order, $orderStatusHistory, $orderDelivery);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $modelOrder->getOrderData($order, $orderStatusHistory, $orderDelivery);

            $em->persist($order);
            $em->persist($orderStatusHistory);
            $em->persist($orderDelivery);
            $em->flush();

            return $this->redirectToRoute('order_edit', array('id' => $order->getId()));
        }

        return $this->render('ZenomaniaCoreBundle:order:edit.html.twig', array(
            'order' => $order,
            'data' => $data,
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

    public function createEditForm(
        ModelOrder &$modelOrder,
        Order $order,
        OrderStatusHistory &$orderStatusHistory,
        OrderDelivery $orderDelivery
    ) {
        $modelOrder->setStatusId($order->getStatusId());

        $modelOrder->setUserId($order->getUserId());
        $modelOrder->setCreatedAt($order->getCreatedAt());
        $modelOrder->setUpdatedAt($order->getUpdatedAt());

        $orderStatusHistory->setOrderId($order);
        $orderStatusHistory->setFromOrderStatusId($order->getStatusId());

        $modelOrder->setClientName($orderDelivery->getClientName());
        $modelOrder->setPhone($orderDelivery->getPhone());
        $modelOrder->setAddress($orderDelivery->getAddress());
        $modelOrder->setNoteDelivery($orderDelivery->getNote());
        return $this->createForm('Zenomania\CoreBundle\Form\OrderType', $modelOrder);
    }
}