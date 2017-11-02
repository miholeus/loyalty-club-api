<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 31.10.17
 * Time: 17:27
 */

namespace Zenomania\CoreBundle\Controller;


use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Zenomania\CoreBundle\Entity\Product;

class ProductController extends Controller
{
    /**
     * Lists all product entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('ZenomaniaCoreBundle:Product')->findAll();

        return $this->render('ZenomaniaCoreBundle:product:index.html.twig', array(
            'products' => $products,
        ));
    }

    /**
     * Finds and displays a product entity.
     * @param Product $product
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Product $product)
    {
        $deleteForm = $this->createDeleteForm($product);

        return $this->render('ZenomaniaCoreBundle:product:show.html.twig', array(
            'product' => $product,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a new product entity.
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $product = new Product();
        /** @var Form $form */
        $form = $this->createForm('Zenomania\CoreBundle\Form\ProductType', $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $service = $this->get('product.service');

            try {
                $service->save($product);
                return $this->redirectToRoute('product_show', array('id' => $product->getId()));
            } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
                $form->addError(new FormError($e->getMessage()));
            }
        }

        return $this->render('ZenomaniaCoreBundle:product:new.html.twig', array(
            'product' => $product,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing product entity.
     * @param Request $request
     * @param Product $product
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Product $product)
    {
        $deleteForm = $this->createDeleteForm($product);
        /** @var Form $form */
        $editForm = $this->createForm('Zenomania\CoreBundle\Form\ProductType', $product);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $service = $this->get('product.service');

            try {
                $service->save($product);
                return $this->redirectToRoute('product_edit', array('id' => $product->getId()));
            } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
                $form->addError(new FormError($e->getMessage()));
            }
        }

        return $this->render('ZenomaniaCoreBundle:product:edit.html.twig', array(
            'product' => $product,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a product entity.
     * @param Request $request
     * @param Product $product
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request,Product $product)
    {
        $form = $this->createDeleteForm($product);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush();
        }
        return $this->redirectToRoute('product_index');

    }

    /**
     * Creates a form to delete a product entity.
     *
     * @param Product $product The product entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Product $product)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('product_delete', array('id' => $product->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}