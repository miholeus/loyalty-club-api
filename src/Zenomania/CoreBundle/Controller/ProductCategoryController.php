<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 01.11.17
 * Time: 11:21
 */

namespace Zenomania\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Zenomania\CoreBundle\Entity\ProductCategory;

class ProductCategoryController extends Controller
{
    /**
     * Lists all category entities.
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('ZenomaniaCoreBundle:ProductCategory')->findAll();

        return $this->render('ZenomaniaCoreBundle:productcategory:index.html.twig', array(
            'productCategories' => $categories,
        ));
    }

    /**
     * Finds and displays a category entity.
     * @param ProductCategory $category
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(ProductCategory $category)
    {
        $deleteForm = $this->createDeleteForm($category);

        return $this->render('ZenomaniaCoreBundle:productcategory:show.html.twig', array(
            'productCategory' => $category,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a new category entity.
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $category = new ProductCategory();
        $form = $this->createForm('Zenomania\CoreBundle\Form\ProductCategoryType', $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('productcategory_show', array('id' => $category->getId()));
        }

        return $this->render('ZenomaniaCoreBundle:productcategory:new.html.twig', array(
            'productCategory' => $category,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing category entity.
     * @param Request $request
     * @param ProductCategory $category
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, ProductCategory $category)
    {
        $deleteForm = $this->createDeleteForm($category);
        $editForm = $this->createForm('Zenomania\CoreBundle\Form\ProductCategoryType', $category);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('productcategory_edit', array('id' => $category->getId()));
        }

        return $this->render('ZenomaniaCoreBundle:productcategory:edit.html.twig', array(
            'productCategory' => $category,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a category entity.
     * @param Request $request
     * @param ProductCategory $category
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, ProductCategory $category)
    {
        $form = $this->createDeleteForm($category);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($category);
            $em->flush();
        }
        return $this->redirectToRoute('productcategory_index');

    }

    /**
     * Creates a form to delete a category entity.
     *
     * @param ProductCategory $category The category entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ProductCategory $category)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('productcategory_delete', array('id' => $category->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}