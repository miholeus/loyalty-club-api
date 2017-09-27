<?php

namespace Zenomania\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Zenomania\CoreBundle\Entity\PromoCoupon;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Zenomania\CoreBundle\Entity\PromoCouponAction;
use Zenomania\CoreBundle\Form\Model\FileUpload;

/**
 * Promocoupon controller.
 *
 */
class PromoCouponController extends Controller
{
    /**
     * Lists all promoCoupon entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $promoCoupons = $em->getRepository('ZenomaniaCoreBundle:PromoCoupon')->findAll();

        return $this->render('ZenomaniaCoreBundle:promocoupon:index.html.twig', array(
            'promoCoupons' => $promoCoupons,
        ));
    }

    /**
     * Creates a new promoCoupon entity.
     *
     */
    public function newAction(Request $request)
    {
        $promoCoupon = new Promocoupon();
        $form = $this->createForm('Zenomania\CoreBundle\Form\PromoCouponType', $promoCoupon);
        $form->handleRequest($request);

        $fileUpload = new FileUpload();
        $uploadForm = $this->createForm('Zenomania\CoreBundle\Form\PromoCouponUploadType', $fileUpload);
        $uploadForm->handleRequest($request);

        if ($uploadForm->isSubmitted() && $uploadForm->isValid()) {
            $dataFile = file_get_contents($fileUpload->getFile()->getPathName());

            $serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder(';', '"', '\\', '~')]);
            $data = $serializer->decode($dataFile, 'csv');

            $promoCouponRepository = $this->getDoctrine()->getRepository('ZenomaniaCoreBundle:PromoCoupon');
            $pcactionRepository = $this->getDoctrine()->getRepository('ZenomaniaCoreBundle:PromoCouponAction');

            $result = ['new' => 0, 'duplicate' => 0, 'error' => 0];
            foreach ($data as $row) {
                if (count($row) != 3) {
                    $result['error']++;
                    continue;
                }

                $pcaction = $pcactionRepository->findOneBy(['caption' => $row[FileUpload::FIELD_ACTION]]);

                if (empty($pcaction)) {
                    $params = [
                        'club_owner' => 9,
                        'caption' => $row[FileUpload::FIELD_ACTION]
                    ];

                    $pcaction = PromoCouponAction::fromArray($params);
                    $pcactionRepository->save($pcaction);
                }

                $duplicate = $promoCouponRepository->findCouponByCode($row[FileUpload::FIELD_CODE]);
                if (!empty($duplicate)) {
                    $result['duplicate']++;
                    continue;
                }

                $params = [
                    'pcaction' => $pcaction,
                    'code' => $row[FileUpload::FIELD_CODE],
                    'points' => $row[FileUpload::FIELD_COUNT_ZEN],
                    'activated' => false,
                ];

                $promoCoupon = PromoCoupon::fromArray($params);
                $promoCouponRepository->save($promoCoupon);
                $result['new']++;
            }

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
