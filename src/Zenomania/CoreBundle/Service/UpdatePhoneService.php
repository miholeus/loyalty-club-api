<?php
/**
 * @package    Zenomania\CoreBundle\Service
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */

namespace Zenomania\CoreBundle\Service;

use Zenomania\CoreBundle\Form\Model\UpdatePhone;
use Zenomania\CoreBundle\Service\Sms\Message;
use Zenomania\CoreBundle\Service\Token\TokenManagementService;
use Zenomania\CoreBundle\Service\Token\TokenRequestInterface;
use Zenomania\CoreBundle\Entity\User as EntityUser;
use Zenomania\CoreBundle\Entity\Exception\ValidatorException;

/**
 * Updates user's phone by sending code using SMS service
 */
class UpdatePhoneService extends TokenManagementService implements TokenRequestInterface
{
    const TOKEN_PHONE_REQUEST = 'token:phone:request';
    const TOKEN_PHONE_SESSION = 'token:phone:session';// identify user requests
    const PHONE_REQUEST_TTL = 3600;// time to life for registration key @todo use config for ttl settings
    /**
     * Support function that returns session token name
     *
     * @param $token
     * @return string
     */
    protected function getSessionTokenName($token)
    {
        return $this->getRequestTokenName($token);
    }
    /**
     * Support function that returns request token name
     *
     * @param $token
     * @return string
     */
    protected function getRequestTokenName($token)
    {
        return sprintf('%s:%s', self::TOKEN_PHONE_REQUEST, $token);
    }

    protected function getSessionTokenKey($token)
    {
        return $this->getSessionTokenName($token);
    }

    /**
     * Remembers token and sends request
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
        $storage->set($key, json_encode(['code' => $smsKey, 'phone' => $phone]), self::PHONE_REQUEST_TTL);

        $messageText = $this->getMessage($smsKey);
        $messageService = $this->getMessageService();
        $message = new Message();
        $message->setPhone($phone);
        $message->setText($messageText);
        $messageService->send($message);

        return $smsKey;
    }

    /**
     * @param array $data
     * @return UpdatePhone
     * @throws ValidatorException
     */
    public function tokenByRequest(array $data)
    {
        $model = new UpdatePhone($data);
        if (null === $model->getToken()) {
            throw new ValidatorException("Update phone token is not provided");
        }
        return $model;
    }
    /**
     * Updates user's phone
     *
     * @param EntityUser $user
     * @param $phone
     */
    public function updatePhone(EntityUser $user, $phone)
    {
        $service = $this->getContainer()->get('user.service');
        $user->setPhone($phone);

        $service->save($user);
    }
    /**
     * Registration message
     *
     * @param $value
     * @return string
     */
    protected function getMessage($value)
    {
        return sprintf('Для смены номера телефона введите код %s', $value);
    }
}
