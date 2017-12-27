<?php

namespace Zenomania\CoreBundle\Controller;

use Zenomania\CoreBundle\Entity\City;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * City controller.
 *
 */
class CityController extends Controller
{
    const ITEMS_ON_PAGE = 50;

    /**
     * Lists all city entities.
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $paginator = $em->getRepository('ZenomaniaCoreBundle:City')->getPaginator();

        $paginator->setPageSize(self::ITEMS_ON_PAGE);
        $paginator->setCurrentPage($request->get('page', 1));
        $paginator->setRoute('city_index');
        $paginator->setRequest($request);

        return $this->render('ZenomaniaCoreBundle:city:index.html.twig', array(
            'cities' => $paginator->getQuery()->getResult(),
            'paginator' => $paginator,
        ));
    }

    /**
     * Creates a new city entity.
     *
     */
    public function newAction(Request $request)
    {
        $city = new City();
        $form = $this->createForm('Zenomania\CoreBundle\Form\CityType', $city);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($city);
            $em->flush();

            return $this->redirectToRoute('city_show', array('id' => $city->getId()));
        }

        return $this->render('ZenomaniaCoreBundle:city:new.html.twig', array(
            'city' => $city,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a city entity.
     *
     */
    public function showAction(City $city)
    {
        $deleteForm = $this->createDeleteForm($city);

        return $this->render('ZenomaniaCoreBundle:city:show.html.twig', array(
            'city' => $city,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing city entity.
     *
     */
    public function editAction(Request $request, City $city)
    {
        $deleteForm = $this->createDeleteForm($city);
        $editForm = $this->createForm('Zenomania\CoreBundle\Form\CityType', $city);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('city_edit', array('id' => $city->getId()));
        }

        return $this->render('ZenomaniaCoreBundle:city:edit.html.twig', array(
            'city' => $city,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a city entity.
     *
     */
    public function deleteAction(Request $request, City $city)
    {
        $form = $this->createDeleteForm($city);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($city);
            $em->flush();
        }

        return $this->redirectToRoute('city_index');
    }

    /**
     * Creates a form to delete a city entity.
     *
     * @param City $city The city entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(City $city)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('city_delete', array('id' => $city->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
