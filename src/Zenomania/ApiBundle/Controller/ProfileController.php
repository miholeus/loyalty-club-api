<?php
/**
 * @package    Zenomania\ApiBundle\Controller
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Zenomania\ApiBundle\Form\UserProfileType;
use Zenomania\ApiBundle\Form\Model\UserProfile;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use Zenomania\CoreBundle\Service\Upload\FilePathStrategy;
use FOS\RestBundle\Controller\Annotations\Route;

class ProfileController extends RestController
{
    /**
     *
     * ### Failed Response ###
     *      {
     *          {
     *              "success": false,
     *              "exception": {
     *                  "code": 400,
     *                  "message": "Bad Request"
     *              },
     *              "errors": null
     *      }
     *
     * ### Success Response ###
     *      {
     *          "data":{
     *              "id":<user id>,
     *              "avatar": <string>,
     *              "avatar_small": <string>,
     *              "birth_date": <string>,
     *              "email": <string>,
     *              "first_name": <string>,
     *              "last_name": <string>,
     *              "middle_name": <string>,
     *              "login": <string>,
     *              "phone": <string>,
     *              "highest_place": <integer>,
     *              "rating": <integer>
     *          },
     *          "time":<time request>
     *      }
     *
     * @ApiDoc(
     *  section="Профиль",
     *  resource=true,
     *  description="Профиль пользователя",
     *  statusCodes={
     *         200="При успешном запросе",
     *         400="Ошибка запроса"
     *     },
     *  headers={
     *      {
     *          "name"="X-AUTHORIZE-TOKEN",
     *          "description"="access key header",
     *          "required"=true
     *      }
     *    },
     *  output="\Zenomania\ApiBundle\Service\Transformer\User\UserProfileTransformer"
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getProfileAction()
    {
        $user = $this->getUser();
        $transformer = $this->get('api.data.transformer.user.profile_transformer');

        $data = $this->getResourceItem($user, $transformer);
        $view = $this->view($data);
        return $this->handleView($view);
    }

    /**
     *
     * ### Failed Response ###
     *      {
     *          {
     *              "success": false,
     *              "exception": {
     *                  "code": 400,
     *                  "message": "Bad Request"
     *              },
     *              "errors": null
     *      }
     *
     * ### Success Response ###
     *      {
     *
     *      }
     *
     * @ApiDoc(
     *  section="Профиль",
     *  resource=true,
     *  description="Редактирование Профиля пользователя",
     *  statusCodes={
     *         204="При успешном запросе",
     *         400="Ошибка запроса"
     *     },
     *  headers={
     *      {
     *          "name"="X-AUTHORIZE-TOKEN",
     *          "description"="access key header",
     *          "required"=true
     *      }
     *    }
     * )
     *
     * @Rest\RequestParam(name="first_name", description="Имя")
     * @Rest\RequestParam(name="last_name", description="Фамилия")
     * @Rest\RequestParam(name="middle_name", description="Отчество")
     * @Rest\RequestParam(name="email", description="Электронная почта")
     * @Rest\RequestParam(name="city", description="Город")
     * @Rest\RequestParam(name="district", description="Район")
     * @Rest\RequestParam(name="birth_date", description="Дата рождения")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function putProfileAction(Request $request)
    {
        $profile = new UserProfile();
        $profile->setUser($this->getUser());

        $form = $this->createForm(UserProfileType::class, $profile);
        $this->processForm($request, $form);

        if (!$form->isValid()) {
            throw $this->createFormValidationException($form);
        }

        $service = $this->get('api.user_profile');
        $service->save($form->getData());

        $view = $this->view(null, 204);
        return $this->handleView($view);
    }


    /**
     *
     *
     * @ApiDoc(
     *  section="Профиль",
     *  resource=true,
     *  description="Загрузка фото пользователя",
     *  statusCodes={
     *          204="Успех",
     *          400="Ошибки валидации"
     *     },
     *  headers={
     *      {
     *          "name"="X-AUTHORIZE-TOKEN",
     *          "description"="access key header",
     *          "required"=true
     *      }
     *    }
     * )
     *
     * @Route("/profile/photos")
     * @RequestParam(name="photo", description="Оригинал фотографии", nullable=false)
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postProfilePhotoAction(Request $request)
    {
        $user = $this->getUser();

        $imageBig = $request->files->get('photo');
        if (!$imageBig) {
            throw new HttpException(400, 'Оригинальная картинка не найдена');
        }

        $imageService = $this->get('images.service');
        $originalImage = $imageService->createImageFromFile($imageBig);

        /**
         * Загружаем фото
         */
        $strategy = new FilePathStrategy();
        $strategy->setEntity($user);
        $uploadService = $this->get('file.upload_profile_photo');
        $uploadService->setUploadStrategy($strategy);
        $uploadedOriginalPathArray = $uploadService->upload($imageBig);

        // сохраняем фото в БД
        $originalImage->setPath($uploadedOriginalPathArray['path']);
        $originalImage->setSize($imageBig->getClientSize());
        $imageService->save($originalImage);

        // Привязываем фото к пользователю (также см. TaskBundle\Entity\Listener\UserListener)
        $userService = $this->get('user.service');
        $user->setAvatar(new File($uploadedOriginalPathArray['full_path'], false));
        $userService->save($user);

        $view = $this->view(null, 204);
        return $this->handleView($view);
    }
}