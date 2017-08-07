<?php

namespace Zenomania\ApiBundle\Controller;

use Zenomania\ApiBundle\Service\Exception\AuthenticateException;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Request\ParamFetcher;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Zenomania\CoreBundle\Form\Model\PasswordRecovery;
use Zenomania\CoreBundle\Form\Model\Registration;
use Zenomania\CoreBundle\Service\PasswordRecoveryService;
use Zenomania\CoreBundle\Service\RegistrationService;

class SecurityController extends RestController
{
    /**
     * ### Minimal Response (e.g. anonymous) ###
     *
     *     {
     *       "data": {
     *         "token": <token>
     *       }
     *     }
     *
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
     *
     * @ApiDoc(
     *  section="Аутентификация",
     *  resource=true,
     *  description="Аутентификация пользователя",
     *  statusCodes={
     *         200="При успешной аутентификации",
     *         401="Неверные данные для аутентификации",
     *         403="Доступ запрещён",
     *         404="Пользователь не найден",
     *         400="Не указаны необходимые параметры запроса"
     *     },
     *  responseMap={
     *         401={
     *           "class"="ApiBundle\Service\Exception\AuthenticateException",
     *           "parsers"={"Nelmio\ApiDocBundle\Parser\JmsMetadataParser"}
     *         }
     *     },
     *  headers={
     *      {
     *          "name"="X-AUTHORIZE-KEY",
     *          "description"="access key header",
     *          "required"=true
     *      }
     *    }
     * )
     *
     *
     * @RequestParam(name="phone", description="Phone")
     * @RequestParam(name="password", description="Password")
     *
     * @param ParamFetcher $paramFetcher
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postLoginAction(ParamFetcher $paramFetcher)
    {
        $service = $this->get('api.auth_service');
        $keyProvider = $this->get('api.key_provider');

        $phone = $paramFetcher->get('phone');
        $password = $paramFetcher->get('password');

        $user = $service->authenticate($phone, $password);
        $this->get('user.service')->updateLastLoginTime($user);
        $token = $keyProvider->generateToken($user);

        $data = [
            'token' => $token,
        ];

        $view = $this->view($data);

        return $this->handleView($view);
    }

    /**
     * @ApiDoc(
     *  section="Аутентификация",
     *  resource=true,
     *  description="Выход пользователя",
     *  statusCodes={
     *         201="При успешном выходе",
     *         403="Доступ запрещён",
     *         400="Не указаны необходимые параметры запроса"
     *     },
     *  responseMap={
     *         401={
     *           "class"="ApiBundle\Service\Exception\AuthenticateException",
     *           "parsers"={"Nelmio\ApiDocBundle\Parser\JmsMetadataParser"}
     *         }
     *     },
     *  headers={
     *      {
     *          "name"="X-AUTHORIZE-TOKEN",
     *          "description"="access token header",
     *          "required"=true
     *      }
     *    }
     * )
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postLogoutAction(Request $request)
    {
        $keyProvider = $this->get('api.key_provider');

        $keyProvider->deleteUserToken($request->headers->get('X-AUTHORIZE-TOKEN'));

        $view = $this->view(null, 204);
        return $this->handleView($view);
    }

    /**
     * ### Minimal Response (e.g. anonymous) ###
     *
     *     {
     *       "data": {
     *         "token": <token>,
     *         "message": <сообщение о следующем шаге>
     *         "next_step_url": <url> куда переходить дальше с проверкой
     *       }
     *     }
     *
     * @ApiDoc(
     *  section="Регистрация",
     *  resource=true,
     *  description="Регистрация пользователя / шаг 1",
     *  statusCodes={
     *         200="При успешной выдаче токена",
     *         400="При ошибках валидации"
     *     },
     *  headers={
     *      {
     *          "name"="X-AUTHORIZE-KEY",
     *          "description"="access key header",
     *          "required"=true
     *      }
     *    }
     * )
     *
     *
     * @RequestParam(name="phone", description="Phone")
     *
     * @param Request $request
     * @param ParamFetcher $paramFetcher
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postRegisterTokenAction(Request $request, ParamFetcher $paramFetcher)
    {
        $phone = $paramFetcher->get('phone');
        $authService = $this->get('api.auth_service');

        if ($authService->validPhone($phone)) {
            throw new HttpException(400, "Phone is already registered. Try to recover your password.");
        }

        $service = $this->get('task.service.registration');
        $token = $service->getTokenStorage()->getToken(RegistrationService::TOKEN_REGISTER_SESSION);
        $service->makeRequest($phone, $token);

        $data = [
            'token' => $token,
            'message' => 'Вам было отправлено смс с кодом авторизации',
            'next_step_url' => sprintf("%s://%s%s", $request->getScheme(), $request->getHost(), $this->generateUrl('post_register_confirm'))
        ];

        $view = $this->view($data);

        return $this->handleView($view);
    }

    /**
     * ### Minimal Response (e.g. anonymous) ###
     *
     *     {
     *       "data": {
     *         "token": <token>,
     *         "next_step_url": <url> куда переходить дальше с проверкой
     *       }
     *     }
     *
     * @ApiDoc(
     *  section="Регистрация",
     *  resource=true,
     *  description="Регистрация пользователя / шаг 2",
     *  statusCodes={
     *         200="При успешном подтверждении токена",
     *         400="При ошибках валидации",
     *         403="При невалидном коде регистрации"
     *     },
     *  headers={
     *      {
     *          "name"="X-AUTHORIZE-KEY",
     *          "description"="access key header",
     *          "required"=true
     *      }
     *    }
     * )
     *
     * @RequestParam(name="token", description="Request token")
     * @RequestParam(name="code", description="Registration code")
     *
     * @param Request $request
     * @param ParamFetcher $paramFetcher
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postRegisterConfirmAction(Request $request, ParamFetcher $paramFetcher)
    {
        $token = $paramFetcher->get('token');
        $code  = $paramFetcher->get('code');

        $service = $this->get('task.service.registration');

        if (!$service->isTokenValid($token, $code)) {
            throw new AuthenticateException(403, "Not Valid code");
        }
        $requestData = $service->getDataByToken($token);

        try {
            $registerToken = $service->makeConfirmRequest($token, $requestData);
        } catch (\Zenomania\CoreBundle\Service\Token\InvalidTokenException $e) {
            throw new HttpException(400, $e->getMessage());
        }

        $data = [
            'token' => $registerToken,
            'next_step_url' => sprintf("%s://%s%s", $request->getScheme(), $request->getHost(), $this->generateUrl('post_register'))
        ];

        $view = $this->view($data);

        return $this->handleView($view);
    }

    /**
     * ### Minimal Response (e.g. anonymous) ###
     *
     *     {
     *       "data": {
     *         "id": <id пользователя>
     *       }
     *     }
     *
     * @ApiDoc(
     *  section="Регистрация",
     *  resource=true,
     *  description="Регистрация пользователя / шаг 3",
     *  statusCodes={
     *         200="При успешном подтверждении токена",
     *         400="При ошибках валидации",
     *         403="При невалидном коде регистрации"
     *     },
     *  headers={
     *      {
     *          "name"="X-AUTHORIZE-KEY",
     *          "description"="access key header",
     *          "required"=true
     *      }
     *    }
     * )
     *
     * @RequestParam(name="token", description="Request token", allowBlank=false)
     * @RequestParam(name="first_name", description="User first name", allowBlank=false)
     * @RequestParam(name="last_name", description="User last name", allowBlank=false)
     * @RequestParam(name="middle_name", description="User middle name", nullable=true, allowBlank=true)
     * @RequestParam(name="login", description="User login", allowBlank=false)
     * @RequestParam(name="password", description="User password", allowBlank=false)
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postRegisterAction(Request $request)
    {
        $registration = new Registration();

        $form = $this->createForm('\Zenomania\CoreBundle\Form\Registration', $registration, [
            'password_text' => true,
            'flow_step' => 3,
            'allow_extra_fields' => true,
            'validation_groups' => ['flow_registration_step3']
        ]);

        $this->processForm($request, $form, false);
        // @todo get actual form errors
        if (!$form->isValid()) {
            throw $this->createFormValidationException($form);
        }

        $service = $this->get('task.service.registration');

        if (!$service->getSessionToken($registration->getToken())) {
            throw new AuthenticateException(403, "Not valid token provided");
        }
        $sessionData = $service->getSessionToken($registration->getToken());

        $registration->setPhone($sessionData['phone']);

        try {
            $user = $service->registerUser($registration);
            $service->clear($registration);
        } catch (\Zenomania\CoreBundle\Entity\Exception\ValidatorException $e) {
            throw new HttpException(400, $e->getMessage());
        }

        $data = [
            'id' => $user->getId()
        ];

        $view = $this->view($data);

        return $this->handleView($view);
    }

    /**
     * ### Minimal Response (e.g. anonymous) ###
     *
     *     {
     *       "data": {
     *         "token": <token>
     *       }
     *     }
     *
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
     *
     * @ApiDoc(
     *  section="Восстановление пароля",
     *  resource=true,
     *  description="Восстановление пароля / шаг 1 (получение кода)",
     *  statusCodes={
     *         200="При успешной аутентификации",
     *         401="Неверные данные для аутентификации",
     *         404="Пользователь не найден",
     *         400="Не указаны необходимые параметры запроса"
     *     },
     *  responseMap={
     *         401={
     *           "class"="ApiBundle\Service\Exception\AuthenticateException",
     *           "parsers"={"Nelmio\ApiDocBundle\Parser\JmsMetadataParser"}
     *         }
     *     },
     *  headers={
     *      {
     *          "name"="X-AUTHORIZE-KEY",
     *          "description"="access key header",
     *          "required"=true
     *      }
     *    }
     * )
     *
     *
     * @RequestParam(name="phone", description="Phone")
     *
     * @param Request $request
     * @param ParamFetcher $paramFetcher
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postRecoverTokenAction(Request $request, ParamFetcher $paramFetcher)
    {
        $phone = $paramFetcher->get('phone');
        $authService = $this->get('api.auth_service');
        if (!$authService->validPhone($phone)) {
            throw new AuthenticateException(400, "Unknown phone");
        }

        $service = $this->get('task.service.password_recovery');
        $token = $service->getTokenStorage()->getToken(PasswordRecoveryService::TOKEN_RECOVERY_SESSION);
        $service->makeRequest($phone, $token);

        $data = [
            'token' => $token,
            'message' => 'Вам было отправлено смс с кодом восстановления пароля',
            'next_step_url' => sprintf("%s://%s%s", $request->getScheme(), $request->getHost(), $this->generateUrl('post_recover_confirm'))
        ];

        $view = $this->view($data);

        return $this->handleView($view);
    }

    /**
     * ### Minimal Response (e.g. anonymous) ###
     *
     *     {
     *       "data": {
     *         "token": <token>,
     *         "next_step_url": <url> куда переходить дальше с проверкой
     *       }
     *     }
     *
     * @ApiDoc(
     *  section="Восстановление пароля",
     *  resource=true,
     *  description="Восстановление пароля / шаг 2 (ввод кода)",
     *  statusCodes={
     *         200="При успешном подтверждении токена",
     *         400="При ошибках валидации",
     *         403="При невалидном коде регистрации"
     *     },
     *  headers={
     *      {
     *          "name"="X-AUTHORIZE-KEY",
     *          "description"="access key header",
     *          "required"=true
     *      }
     *    }
     * )
     *
     * @RequestParam(name="token", description="Request token")
     * @RequestParam(name="code", description="Registration code")
     *
     * @param Request $request
     * @param ParamFetcher $paramFetcher
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postRecoverConfirmAction(Request $request, ParamFetcher $paramFetcher)
    {
        $token = $paramFetcher->get('token');
        $code  = $paramFetcher->get('code');

        $service = $this->get('task.service.password_recovery');

        if (!$service->isTokenValid($token, $code)) {
            throw new AuthenticateException(403, "Not Valid code");
        }
        $requestData = $service->getDataByToken($token);

        try {
            $registerToken = $service->makeConfirmRequest($token, $requestData);
        } catch (\Zenomania\CoreBundle\Service\Token\InvalidTokenException $e) {
            throw new HttpException(400, $e->getMessage());
        }

        $data = [
            'token' => $registerToken,
            'next_step_url' => sprintf("%s://%s%s", $request->getScheme(), $request->getHost(), $this->generateUrl('post_recover'))
        ];

        $view = $this->view($data);

        return $this->handleView($view);
    }

    /**
     * ### Minimal Response (e.g. anonymous) ###
     *
     *     {
     *       "data": {
     *         "success": true
     *       }
     *     }
     *
     * @ApiDoc(
     *  section="Восстановление пароля",
     *  resource=true,
     *  description="Восстановление пароля / шаг 3 (смена пароля)",
     *  statusCodes={
     *         200="При успешном подтверждении токена",
     *         400="При ошибках валидации",
     *         403="При невалидном коде регистрации"
     *     },
     *  headers={
     *      {
     *          "name"="X-AUTHORIZE-KEY",
     *          "description"="access key header",
     *          "required"=true
     *      }
     *    }
     * )
     *
     * @RequestParam(name="token", description="Request token")
     * @RequestParam(name="password", description="User password")
     *
     * @param Request $request
     * @param ParamFetcher $paramFetcher
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postRecoverAction(Request $request, ParamFetcher $paramFetcher)
    {
        $token = $paramFetcher->get('token');
        $password = $paramFetcher->get('password');

        $service = $this->get('task.service.password_recovery');

        if (!$service->getSessionToken($token)) {
            throw new AuthenticateException(403, "Not valid token provided");
        }
        $sessionData = $service->getSessionToken($token);
        $user = $this->get('api.auth_service')->findUserByPhone($sessionData['phone']);

        // we need to authenticate user to change password
        $this->get('task.service.authenticate')->authenticate($request, $user);

        $recovery = new PasswordRecovery([
            'password' => $password,
            'phone' => $sessionData['phone'],
            'token' => $token
        ]);

        try {
            $service->recoverPassword($user, $recovery);
            $service->clear($recovery);
        } catch (\Zenomania\CoreBundle\Entity\Exception\ValidatorException $e) {
            throw new HttpException(400, $e->getMessage());
        }

        $data = [
            'success' => true
        ];

        $view = $this->view($data);

        return $this->handleView($view);
    }
}
