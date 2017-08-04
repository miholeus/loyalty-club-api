<?php

namespace Zenomania\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Zenomania\CoreBundle\Annotation\ActionBreadcrumb;
use Zenomania\CoreBundle\Doctrine\CustomPaginator;
use Zenomania\CoreBundle\Entity\Image;
use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Form\Model\Search;
use Zenomania\CoreBundle\Service\Images;
use Zenomania\CoreBundle\Service\Upload\FilePathStrategy;
use Zenomania\CoreBundle\Service\UploadProfilePhoto;

/**
 * User controller.
 *
 */
class UserController extends Controller
{
    const ITEMS_ON_PAGE = 20;

    /**
     * Lists all User entities.
     *
     */
    public function indexAction(Request $request)
    {
        $paginator = new CustomPaginator(
            $this->get('user.service')->getPaginationQuery($request->get('query'))
        );
        $paginator->setPageSize(self::ITEMS_ON_PAGE);
        $paginator->setCurrentPage($request->get('page', 1));
        $paginator->setRoute('user_index');
        $paginator->setRequest($request);
        $searchForm = $this->createForm('Zenomania\CoreBundle\Form\SearchType', new Search($request->get('query')), [
            'action' => $this->generateUrl('user_search_pagination'),
            'query_placeholder' => 'Иван Петров'
        ]);

        return $this->render('ZenomaniaCoreBundle:user:index.html.twig', array(
            'users' => $paginator->getQuery()->getResult(),
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

            return $this->redirectToRoute('user_index', $searchParameters);
        }
        throw new \ErrorException("Search form is not valid");
    }

    /**
     * Creates a new User entity.
     *
     * @ActionBreadcrumb("Create new")
     */
    public function newAction(Request $request)
    {
        $user = new User();
        /** @var Form $form */
        $form = $this->createForm('Zenomania\CoreBundle\Form\UserType', $user, [
            'validation_groups' => ['registration', 'Default']
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->get('user.service')->save($user);

                return $this->redirectToRoute('user_show', array('id' => $user->getId()));
            } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
                $form->addError(new FormError($e->getMessage()));
            }
        }

        return $this->render('ZenomaniaCoreBundle:user:new.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a User entity.
     *
     * @ActionBreadcrumb("Show: %s")
     */
    public function showAction(User $user, Request $request)
    {
        $deleteForm = $this->createDeleteForm($user);
        $this->get('breadcrumbs.service')->renderBreadcrumb($request, $user->getFirstname());

        return $this->render('ZenomaniaCoreBundle:user:show.html.twig', array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     * @ActionBreadcrumb("Edit: %s")
     * @param Request $request
     * @param User    $user
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, User $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        $avatar = $user->getAvatar();

        /** @var Form $editForm */
        $editForm = $this->createForm('Zenomania\CoreBundle\Form\UserType', $user);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            /**
             * Загружаем фото
             */
            $uploadedFile = $user->getAvatar();

            if ($uploadedFile instanceof UploadedFile) {
                $user->setAvatar(null);
                $strategy = new FilePathStrategy();
                $strategy->setEntity($user);
                /** @var UploadProfilePhoto $uploadService */
                $uploadService = $this->get('file.upload_profile_photo');
                $uploadService->setUploadStrategy($strategy);
                $uploadedOriginalPathArray = $uploadService->upload($uploadedFile);

                // сохраняем фото в БД
                /** @var Images $imageService */
                $imageService = $this->get('images.service');
                /** @var Image $originalImage */
                $originalImage = $imageService->createImageFromFile($uploadedFile);
                $originalImage->setPath($uploadedOriginalPathArray['path']);
                $originalImage->setSize($uploadedFile->getClientSize());
                $imageService->save($originalImage);

                $user->setAvatar(new File($uploadedOriginalPathArray['full_path']));
                $user->setAvatarSmall($user->getAvatar());// @todo resize image
            } else {
                $user->setAvatar($avatar);// restore avatar

                $rootDirectory = $this->getParameter('upload_dir');

                $avatarSmall = $user->getAvatarSmall();
                $avatarSmall = str_replace($rootDirectory, '', $avatarSmall);
                $user->setAvatarSmall($avatarSmall);

                $avatar = $user->getAvatar();
                $avatar = str_replace($rootDirectory, '', $avatar);
                $user->setAvatar($avatar);
            }

            try {
                $this->get('user.service')->save($user);
                return $this->redirectToRoute('user_edit', array('id' => $user->getId()));
            } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
                $editForm->addError(new FormError($e->getMessage()));
            }
        }
        $this->get('breadcrumbs.service')->renderBreadcrumb($request, $user->getFirstname());

        return $this->render('ZenomaniaCoreBundle:user:edit.html.twig', array(
            'user' => $user,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a User entity.
     *
     */
    public function deleteAction(Request $request, User $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('user_index');
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function profileAction(Request $request, User $user)
    {
        /** @var Form $form */
        $form = $this->createForm('Zenomania\CoreBundle\Form\ProfileType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_profile', array('id' => $user->getId()));
        }

        return $this->render('ZenomaniaCoreBundle:user:profile.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    /**
     * Creates a form to delete a User entity.
     *
     * @param User $user The User entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Возвращает всех пользователей для выбора ответственного проекта
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function searchAction(Request $request)
    {
        $query = ($request->get('q'));
        $userList = $this->getDoctrine()->getRepository('ZenomaniaCoreBundle:User')->findUser($query);
        $resultArray = [];
        /* @var $user User */
        foreach ($userList as $user) {
            $element = [
                'id' => $user->getId(),
                'text' => $user->getFirstname(),
            ];
            $resultArray[] = $element;
        }
        return new JsonResponse($resultArray);
    }
}
