<?php
/**
 * @package    Zenomania\ApiBundle\Controller
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Zenomania\ApiBundle\Form\UserProfileType;
use Zenomania\ApiBundle\Form\Model\UserProfile;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use Zenomania\CoreBundle\Entity\SocialAccount;
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
     *              "matches":<integer>,
     *              "purchases":<integer>,
     *              "predictions":<integer>
     *              "reposts":<integer>,
     *              "invites":<integer>
     *          },
     *          "time":<time request>
     *      }
     *
     * @ApiDoc(
     *  section="Профиль",
     *  resource=true,
     *  description="Вкладка Моя статистика",
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
     *    }
     * )
     *
     * @QueryParam(name="period", requirements="^(month|year)$", allowBlank=true, nullable=true, description="Фильтрация по дате")
     *
     * @param ParamFetcher $paramFetcher
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getProfileStatsAction(ParamFetcher $paramFetcher)
    {
        $transformer = $this->get('api.data.transformer.user.profile_stats_transformer');
        $service = $this->get('api.person_points');

        $params = $this->getParams($paramFetcher, 'stats');
        $params['period'] = !empty($params['period']) ? $params['period'] : null;

        $filter = new \Zenomania\ApiBundle\Request\Filter\ProfileStatsFilter($params);

        $items = $service->getUserPoints($this->getUser(), $filter);

        $data = $this->getResourceItem($items, $transformer);
        $view = $this->view($data);
        return $this->handleView($view);
    }

    /**
     * ### Failed Response ###
     *
     *     {
     *       "success": false
     *       "exception": {
     *         "code": <code>,
     *         "message": <message>
     *       }
     *     }
     *
     * ### Success Response ###
     *      {
     *          "data":{
     *              "id":<post id>
     *          },
     *          "time":<time request>
     *      }
     *
     * @ApiDoc(
     *  section="Профиль",
     *  resource=true,
     *  description="Создание репоста новости",
     *  statusCodes={
     *          204="Успех",
     *          400="Ошибка запроса"
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
     * @RequestParam(name="news", description="id новости для репоста в ВК", nullable=false)
     *
     * @param ParamFetcher $paramFetcher
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postRepostAction(ParamFetcher $paramFetcher)
    {
        $newsId = $paramFetcher->get('news');
        $newsRepository = $this->get('repository.news_repository');
        $news = $newsRepository->find($newsId);
        $groupId = $this->getParameter('vk_group_id');

        if (empty($news)) {
            throw new HttpException(400, 'Данная новость не найдена');
        }

        $user = $this->getUser();
        $socialAccountRepository = $this->get('repository.social_account_repository');
        /** @var SocialAccount $socialAccount */
        $socialAccount = $socialAccountRepository->findAccountVkByUser($user);

        if (empty($socialAccount)) {
            throw new HttpException(400, 'Нет привязки к соц.сети');
        }

        $serviceVk = $this->get('api.client.vk');
        $response = $serviceVk->repost($news, $socialAccount->getAccessToken(), $groupId);

        $data = [
            'id' => $response
        ];

        $view = $this->view($data);

        return $this->handleView($view);
    }
}