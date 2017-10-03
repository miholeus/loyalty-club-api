<?php

namespace Zenomania\CoreBundle\Controller;

use Zenomania\CoreBundle\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Event controller.
 *
 */
class EventController extends Controller
{
    const ITEMS_ON_PAGE = 20;

    /**
     * Lists all event entities.
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $paginator = $em->getRepository('ZenomaniaCoreBundle:Event')->getPaginator();

        $paginator->setPageSize(self::ITEMS_ON_PAGE);
        $paginator->setCurrentPage($request->get('page', 1));
        $paginator->setRoute('event_index');
        $paginator->setRequest($request);

        return $this->render('ZenomaniaCoreBundle:event:index.html.twig', array(
            'events' => $paginator->getQuery()->getResult(),
            'paginator' => $paginator
        ));
    }

    /**
     * Creates a new event entity.
     *
     */
    public function newAction(Request $request)
    {
        $event = new Event();
        $form = $this->createForm('Zenomania\CoreBundle\Form\EventType', $event);
        $form->handleRequest($request);

        $service = $this->get('event.service');

        if ($form->isSubmitted() && $form->isValid()) {

            $service->save($form->getData());

            return $this->redirectToRoute('event_show', array('id' => $event->getId()));
        }

        return $this->render('ZenomaniaCoreBundle:event:new.html.twig', array(
            'event' => $event,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a event entity.
     *
     */
    public function showAction(Event $event)
    {
        $deleteForm = $this->createDeleteForm($event);

        return $this->render('ZenomaniaCoreBundle:event:show.html.twig', array(
            'event' => $event,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Подсчёт прогнозов пользователей
     */
    public function calculateAction(Event $event)
    {
        $service = $this->get('event.service');
        $service->calculate($event);


        $deleteForm = $this->createDeleteForm($event);

        return $this->render('ZenomaniaCoreBundle:event:show.html.twig', array(
            'event' => $event,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Пересчитать прогнозы пользователей
     */
    public function recountAction(Event $event)
    {
        $deleteForm = $this->createDeleteForm($event);

        return $this->render('ZenomaniaCoreBundle:event:show.html.twig', array(
            'event' => $event,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing event entity.
     *
     */
    public function editAction(Request $request, Event $event)
    {
        $deleteForm = $this->createDeleteForm($event);

        $service = $this->get('event.service');

        $form = $this->createForm('Zenomania\CoreBundle\Form\EventType', $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $service->save($form->getData());

            return $this->redirectToRoute('event_show', array('id' => $event->getId()));
        }

        return $this->render('ZenomaniaCoreBundle:event:edit.html.twig', array(
            'event' => $event,
            'form' => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a event entity.
     *
     */
    public function deleteAction(Request $request, Event $event)
    {
        $form = $this->createDeleteForm($event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($event);
            $em->flush();
        }

        return $this->redirectToRoute('event_index');
    }

    /**
     * Creates a form to delete a event entity.
     *
     * @param Event $event The event entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Event $event)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('event_delete', array('id' => $event->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
