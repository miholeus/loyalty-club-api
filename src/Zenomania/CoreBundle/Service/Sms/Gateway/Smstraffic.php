<?php
/**
 * @package   Zenomania\CoreBundle/Service/Sms
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */

/**
 * @namespace
 */
namespace Zenomania\CoreBundle\Service\Sms\Gateway;

use Zenomania\CoreBundle\Service\Sms;

/**
 * Send sms messages through smstraffic.ru
 */
class Smstraffic extends AbstractGateway
{
    /**
     * Gateway url
     *
     * @var string
     */
    protected $gatewayUrl = 'https://api.smstraffic.ru/multi.php';
    /**
     * From whom field in sms message
     *
     * @var string
     */
    protected $originator = 'Selloutsport';

    /**
     * Gateway name
     *
     * @return mixed
     */
    public function getName()
    {
        return 'smstraffic';
    }


    /**
     * Send message
     *
     * @param Sms\Message $message
     * @throws Exception
     * @return bool|int|mixed
     */
    public function send(Sms\Message $message)
    {
        // TODO: validate msg
        $adapter = new \Zend\Http\Client\Adapter\Curl();

        $client = new \Zend\Http\Client(
            null, array(
                'adapter' => $adapter,
                'verify' => false
            )
        );

        if (null === $this->getLogin() || null === $this->getPassword()) {
            throw new Exception("Smstraffic gateway error: login/password can not be empty");
        }

        // Установка POST данных
        // Полное API: https://www.smstraffic.ru/doc/techdoc_corp.doc
        $rus = 5; // message on russian in utf-8 encoding
        if (null !== $message->translit) {
            $translit = (bool)$message->translit;
            if ($translit) {
                $rus = 0;
            }
        }

        $data = array(
            'login' => $this->getLogin(),
            'password' => $this->getPassword(),
            'originator' => $this->getOriginator(),
            'phones' => $message->getPhone(),
            'message' => 5 == $rus ? $message->getText() : mb_convert_encoding(
                $message->getText(),
                'cp1251',
                'utf-8'
            ),
            'rus' => $rus,
            'autotruncate' => 1,
            'max_parts' => 7,
            'want_sms_ids' => 1,
            'gap' => 0.05
        );


        $client->setParameterPost($data);
        $client->setUri($this->getGatewayUrl());
        $client->setMethod(\Zend\Http\Request::METHOD_POST);

        $response = $client->send();
        /**
         * <reply>
            <result>OK</result>
            <code></code>
            <description>queued 2 messages</description>
            <message_infos>
                <message_info>
                <phone>79051112233</phone>
                <sms_id>8287366071</sms_id>
                <push_id>a</push_id>
                </message_info>
                <message_info>
                <phone>79051112233</phone>
                <sms_id>8287366073</sms_id>
                <push_id>a</push_id>
                </message_info>
            </message_infos>
           </reply>
         */
        $body = $response->getBody();

        if ($response->isSuccess()) {
            $xml = simplexml_load_string($body);

            if (!empty($xml->message_infos[0]->message_info->sms_id)) {
                return $xml->message_infos[0]->message_info->sms_id->__toString();
            } else {
                $error = $xml->description->__toString();
                throw new Exception('Ошибка при отправке SMS: ' . $error);
            }
        } else {
            throw new Exception('Ошибка при отправке запроса');
        }
    }
}
