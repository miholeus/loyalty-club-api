<?php

namespace Zenomania\CoreBundle\Controller;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Response;
use Zenomania\CoreBundle\Entity\PromoCoupon;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Zenomania\CoreBundle\Form\Model\FileUpload;
use Zenomania\CoreBundle\Form\Model\Search;

/**
 * Promocoupon controller.
 *
 */
class PromoCouponController extends Controller
{
    const ITEMS_ON_PAGE = 20;

    /**
     * Lists all promoCoupon entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $paginator = $em->getRepository('ZenomaniaCoreBundle:PromoCoupon')->getPaginator($request->get('query'));

        $paginator->setPageSize(self::ITEMS_ON_PAGE);
        $paginator->setCurrentPage($request->get('page', 1));
        $paginator->setRoute('promocoupon_index');
        $paginator->setRequest($request);

        $searchForm = $this->createForm('Zenomania\CoreBundle\Form\SearchType', new Search($request->get('query')), [
            'action' => $this->generateUrl('promocoupon_search_pagination'),
            'query_placeholder' => 'ZENITPROMO100'
        ]);

        return $this->render('ZenomaniaCoreBundle:promocoupon:index.html.twig', array(
            'promoCoupons' => $paginator->getQuery()->getResult(),
            'paginator' => $paginator,
            'searchForm' => $searchForm->createView()
        ));
    }

    public function searchPaginationAction(Request $request)
    {
        /** @var Form $searchForm */
        $searchForm = $this->createForm('Zenomania\CoreBundle\Form\SearchType');
        $searchForm->handleRequest($request);
        if ($searchForm->isValid()) {
            $searchParameters = $searchForm->get('clear')->isClicked()
                ? [] : ['query' => $searchForm->getData()->getQuery()];

            return $this->redirectToRoute('promocoupon_index', $searchParameters);
        }
        throw new \ErrorException("Search form is not valid");
    }

    /**
     * Creates a new promoCoupon entity.
     *
     */
    public function newAction(Request $request)
    {
        // Форма для создания единичных промо-купонов
        $promoCoupon = new Promocoupon();
        $form = $this->createForm('Zenomania\CoreBundle\Form\PromoCouponType', $promoCoupon);
        $form->handleRequest($request);

        // Форма для загрузки промо-купонов из файла
        $fileUpload = new FileUpload();
        $uploadForm = $this->createForm('Zenomania\CoreBundle\Form\PromoCouponUploadType', $fileUpload);
        $uploadForm->handleRequest($request);

        if ($uploadForm->isSubmitted() && $uploadForm->isValid()) {
            $dataFile = file_get_contents($fileUpload->getFile()->getPathName());
            $promoCouponService = $this->get('promocoupon.service');
            $result = $promoCouponService->upload($dataFile);

            return $this->render('ZenomaniaCoreBundle:promocoupon:upload.html.twig', array(
                'result' => $result,
            ));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($promoCoupon);
            $em->flush();

            return $this->redirectToRoute('promocoupon_show', array('id' => $promoCoupon->getId()));
        }

        return $this->render('ZenomaniaCoreBundle:promocoupon:new.html.twig', array(
            'promoCoupon' => $promoCoupon,
            'form' => $form->createView(),
            'uploadForm' => $uploadForm->createView(),
        ));
    }

    /**
     * Finds and displays a promoCoupon entity.
     *
     */
    public function showAction(PromoCoupon $promoCoupon)
    {
        $deleteForm = $this->createDeleteForm($promoCoupon);

        return $this->render('ZenomaniaCoreBundle:promocoupon:show.html.twig', array(
            'promoCoupon' => $promoCoupon,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing promoCoupon entity.
     *
     */
    public function editAction(Request $request, PromoCoupon $promoCoupon)
    {
        $deleteForm = $this->createDeleteForm($promoCoupon);
        $editForm = $this->createForm('Zenomania\CoreBundle\Form\PromoCouponType', $promoCoupon);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('promocoupon_edit', array('id' => $promoCoupon->getId()));
        }

        return $this->render('ZenomaniaCoreBundle:promocoupon:edit.html.twig', array(
            'promoCoupon' => $promoCoupon,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a promoCoupon entity.
     *
     */
    public function deleteAction(Request $request, PromoCoupon $promoCoupon)
    {
        $form = $this->createDeleteForm($promoCoupon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($promoCoupon);
            $em->flush();
        }

        return $this->redirectToRoute('promocoupon_index');
    }

    /**
     * Creates a form to delete a promoCoupon entity.
     *
     * @param PromoCoupon $promoCoupon The promoCoupon entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PromoCoupon $promoCoupon)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('promocoupon_delete', array('id' => $promoCoupon->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
