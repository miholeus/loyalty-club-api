<?php
/**
 * @package    Zenomania\CoreBundle\Service
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */

namespace Zenomania\CoreBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Zenomania\CoreBundle\Entity\Exception\ValidatorException;
use Zenomania\CoreBundle\Entity\UserRole;
use Zenomania\CoreBundle\Entity\UserStatus;
use Zenomania\CoreBundle\Event\NotificationInterface;
use Zenomania\CoreBundle\Event\User\ReferralCodeAppliedEvent;
use Zenomania\CoreBundle\Form\Model\Registration;
use Zenomania\CoreBundle\Service\Sms\Message;
use Zenomania\CoreBundle\Entity\User as EntityUser;
use Zenomania\CoreBundle\Service\Token\InvalidTokenException;
use Zenomania\CoreBundle\Service\Token\TokenConfirmRequestInterface;
use Zenomania\CoreBundle\Service\Token\TokenManagementService;
use Zenomania\CoreBundle\Service\Traits\EventsAwareTrait;

class RegistrationService extends TokenManagementService implements TokenConfirmRequestInterface
{
    use EventsAwareTrait;

    const TOKEN_REGISTER_SESSION = 'token:register:session';// token created to identify user requests
    const TOKEN_REGISTER_REQUEST = 'token:register:request';
    const REGISTRATION_REQUEST_TTL = 3600;// time to life for registration key @todo use config for ttl settings

    /**
     * @var NotificationInterface
     */
    protected $notificationManager;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->notificationManager = $container->get('event.notification_manager');

    }
    /**
     * Support function that returns request token name
     *
     * @param $token
     * @return string
     */
    protected function getRequestTokenName($token)
    {
        return sprintf('%s:%s', self::TOKEN_REGISTER_REQUEST, $token);
    }

    /**
     * Support function that returns session token name
     *
     * @param $token
     * @return string
     */
    protected function getSessionTokenName($token)
    {
        return sprintf('%s:%s', self::TOKEN_REGISTER_SESSION, $token);
    }

    protected function getSessionTokenKey($token)
    {
        return $this->getSessionTokenName($token);
    }


    /**
     * Remembers token and sends registration request
     *
     * @param string $phone phone number to send key
     * @param string $token token saved in storage to identify user's requests
     * @param array $context additional context for request
     * @return string key to register new user
     */
    public function makeRequest($phone, $token, $context = [])
    {
        $key = $this->getRequestTokenName($token);
        $smsKey = $this->getRandomNumber(6, true);

        if (!empty($context['refcode'])) {
            if (!$this->isReferralCodeValid($context['refcode'])) {
                throw new \RuntimeException(sprintf("Referral code %s is not valid", $context['refcode']));
            }
        }
        $storage = $this->getTokenStorage();
        $storage->set($key, json_encode(array_merge($context, ['code' => $smsKey, 'phone' => $phone])), self::REGISTRATION_REQUEST_TTL);

        $messageText = $this->getMessage($smsKey);
        $messageService = $this->getMessageService();
        $message = new Message();
        $message->setPhone($phone);
        $message->setText($messageText);
        $messageService->send($message);

        return $smsKey;
    }

    /**
     * Register confirm request (after code was received)
     *
     * @param $token
     * @param array $data (['phone' => '<some phone>', 'code' => '<code received>'])
     * @return mixed
     * @throws InvalidTokenException
     */
    public function makeConfirmRequest($token, array $data)
    {
        $storage = $this->getTokenStorage();
        $token = $storage->getToken($token);
        $key = $this->getSessionTokenName($token);
        if (empty($data['phone']) || empty($data['code'])) {
            throw new InvalidTokenException("Request confirmation does not hold <phone> or <code> parameters");
        }
        $data['token'] = $token;

        $storage->set($key, json_encode($data), self::REGISTRATION_REQUEST_TTL);
        return $token;
    }

    /**
     * @param Registration $registration
     * @return EntityUser
     * @throws ValidatorException
     */
    public function registerUser(Registration $registration)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $service = $this->getContainer()->get('user.service');

        // validate registration object
        $constraints = $this->getContainer()->get('validator')->validate($registration, null, ['flow_registration_step3']);
        if ($constraints->count() > 0) {
            // throw first exception in validation constraints
            /** @var \Symfony\Component\Validator\ConstraintViolation $validationConstraint */
            foreach ($constraints as $validationConstraint) {
                $messageTemplate = "Field <%s> has value <%s>. %s";
                $message = sprintf($messageTemplate,
                    $validationConstraint->getPropertyPath(),
                    $validationConstraint->getInvalidValue(),
                    $validationConstraint->getMessage());

                throw new ValidatorException($message);
            }
        }

        $user = new EntityUser();
        $user->setFirstname($registration->getFirstName());
        $user->setLastname($registration->getLastName());
        $user->setMiddlename($registration->getMiddleName());
        $user->setLogin($registration->getLogin());
        $user->setPassword($registration->getPassword());
        $user->setIsActive(true);
        $user->setPhone($registration->getPhone());
        $user->setCreatedOn(new \DateTime());

        $role = $em->getRepository('ZenomaniaCoreBundle:UserRole')->findOneBy(['name' => UserRole::ROLE_USER]);
        $status = $em->getRepository('ZenomaniaCoreBundle:UserStatus')->findOneBy(['code' => UserStatus::STATUS_ACTIVE]);
        $user->setRole($role);
        $user->setStatus($status);

        if (null !== $registration->getReferralCode()) {
            $event = new ReferralCodeAppliedEvent();
            $event->setArgument('code', $registration->getReferralCode());
            $event->setArgument('user', $user);
            $this->attachEvent($event);
        }

        $service->save($user);

        // Update events
        $this->updateEvents();

        return $user;
    }

    /**
     * Registration message
     *
     * @param $value
     * @return string
     */
    protected function getMessage($value)
    {
        return sprintf('Для регистрации введите код %s', $value);
    }

    /**
     * Checks if referral code exists
     *
     * @param $code
     * @return bool
     */
    protected function isReferralCodeValid($code)
    {
        $repo = $this->getContainer()->get('repository.user_referral_code_repository');
        $referralCode = $repo->findByReferralCode($code);
        return null !== $referralCode;
    }
}
