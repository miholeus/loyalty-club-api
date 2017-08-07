<?php
/**
 * @package    Zenomania\CoreBundle\Service
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */

namespace Zenomania\CoreBundle\Service;

use Zenomania\CoreBundle\Entity\Exception\ValidatorException;
use Zenomania\CoreBundle\Entity\UserRole;
use Zenomania\CoreBundle\Entity\UserStatus;
use Zenomania\CoreBundle\Form\Model\Registration;
use Zenomania\CoreBundle\Service\Sms\Message;
use Zenomania\CoreBundle\Entity\User as EntityUser;
use Zenomania\CoreBundle\Service\Token\InvalidTokenException;
use Zenomania\CoreBundle\Service\Token\TokenConfirmRequestInterface;
use Zenomania\CoreBundle\Service\Token\TokenManagementService;

class RegistrationService extends TokenManagementService implements TokenConfirmRequestInterface
{
    const TOKEN_REGISTER_SESSION = 'token:register:session';// token created to identify user requests
    const TOKEN_REGISTER_REQUEST = 'token:register:request';
    const REGISTRATION_REQUEST_TTL = 3600;// time to life for registration key @todo use config for ttl settings

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
     * @return string key to register new user
     */
    public function makeRequest($phone, $token)
    {
        $key = $this->getRequestTokenName($token);
        $smsKey = $this->getRandomNumber(6, true);

        $storage = $this->getTokenStorage();
        $storage->set($key, json_encode(['code' => $smsKey, 'phone' => $phone]), self::REGISTRATION_REQUEST_TTL);

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

        $service->save($user);

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
}
