<?php
/**
 * @package    Zenomania\CoreBundle\Controller
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */

namespace Zenomania\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Zenomania\CoreBundle\Form\Model\Registration;
use Zenomania\CoreBundle\Form\ChangePasswordType;
use Zenomania\CoreBundle\Form\UserByEmailType;
use Zenomania\CoreBundle\Service\Token\InvalidTokenException;

class SecurityController extends Controller
{
    public function loginAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('zenomania_core_homepage');
        }

        $form = $this->createForm('Zenomania\CoreBundle\Form\Login');

        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        $form->handleRequest($request);

        return $this->render('ZenomaniaCoreBundle:security:login.html.twig', [
            'form' => $form->createView(),
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    public function registerAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('zenomania_core_homepage');
        }
        $registration = new Registration();

        $flow = $this->get('core.form.flow.registration');

        $flow->bind($registration);

        $form = $flow->createForm();

        try {
            if ($flow->isValid($form)) {
                $token = $flow->getToken();
                $registration->setToken($token);
                $flow->saveCurrentStepData($form);

                if ($flow->nextStep()) {
                    $form = $flow->createForm();
                } else {
                    $flow->reset();

                    $user = $flow->getService()->registerUser($registration);
                    $flow->getService()->clear($registration);
                    $this->get('core.service.authenticate')->authenticate($request, $user);

                    return $this->redirectToRoute('zenomania_core_homepage');
                }
            }
        } catch (InvalidTokenException $e) {
            $form->addError(new FormError($e->getMessage()));
        }

        return $this->render('ZenomaniaCoreBundle:security:register.html.twig', [
            'form' => $form->createView(),
            'flow' => $flow
        ]);
    }

    /**
     * Sends message to user with instructions to recover password
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function recoverySendMessageAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('zenomania_core_homepage');
        }
        /** @var Form $form */
        $form = $this->createForm(UserByEmailType::class);
        $form->handleRequest($request);
        if ($form->isValid()) {
            /** @var \Zenomania\CoreBundle\Entity\User $user */
            $user = $form->get('user')->getData();
            $service = $this->get('user.service');
            $recoveryCode = $this->get('security.email_password_recovery')
                ->sendPasswordRecoveryCode($user);
            $user->setVerifyEmailUuid($recoveryCode);
            $service->save($user);

            return $this->render('ZenomaniaCoreBundle:security/recovery:code_sent.html.twig', [
                'email' => $user->getEmail()
            ]);
        }
        return $this->render('ZenomaniaCoreBundle:security/recovery:recover.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Updates user's password by code
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function recoveryChangePasswordAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('zenomania_core_homepage');
        }
        /** @var Form $form */
        $form = $this->createForm(ChangePasswordType::class);
        $form->handleRequest($request);
        $service = $this->get('user.service');
        if ($form->isValid()) {
            /** @var \Zenomania\CoreBundle\Entity\User $user */
            $user = $this->get('user.service')
                ->findByRecoveryCode($form->get('code')->getData());
            if ($user) {
                $service->changePassword(
                    $user,
                    $form->get('password')->getData()
                );
                $message = [
                    'header' => 'Восстановление пароля',
                    'text' => 'Пароль успешно изменен, используйте его для входа в систему.',
                    'type' => 'login'
                ];
            } else {
                $message = [
                    'header' => 'Ошибка восстановление пароля',
                    'text' => 'Введен неверный или устаревший код восстановления.',
                    'type' => 'recover'
                ];
            }
        } else {
            $user = $this->get('user.service')
                ->findByRecoveryCode($request->get('code'));

            if ($user) {
                return $this->render('ZenomaniaCoreBundle:security/recovery:change_password.html.twig', [
                    'form' => $form->createView(),
                    'code' => $request->get('code')
                ]);
            } else {
                $message = [
                    'header' => 'Ошибка восстановление пароля',
                    'text' => 'Введен неверный или устаревший код восстановления.',
                    'type' => 'recover'
                ];
            }
        }
        return $this->render('ZenomaniaCoreBundle:security/recovery:message.html.twig', [
            'message' => $message
        ]);
    }
}
