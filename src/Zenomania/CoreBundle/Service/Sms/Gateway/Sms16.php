<?php
/**
 * @package    Zenomania\CoreBundle\Service\Sms\Gateway
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\CoreBundle\Service\Sms\Gateway;

use Zend\Stdlib\Parameters;
use Zenomania\CoreBundle\Service\Sms;

class Sms16 extends AbstractGateway
{
    /**
     * Gateway url
     *
     * @var string
     */
    protected $gatewayUrl = 'https://new.sms16.ru/get/send.php';
    /**
     * Url to get timestamp
     *
     * @var string
     */
    protected $timestampUrl = 'https://new.sms16.ru/get/timestamp.php';
    /**
     * From whom field in sms message
     *
     * @var string
     */
    protected $originator = 'Selloutsport';

    public function getName()
    {
        return 'sms16';
    }

    /**
     * @param \Zend\Http\Client $client
     * @return int
     */
    protected function getTimestamp(\Zend\Http\Client $client) : int
    {
        $request = new \Zend\Http\Request();
        $request->setUri($this->timestampUrl);
        $request->setMethod(\Zend\Http\Request::METHOD_GET);

        $response = $client->send($request);
        return intval($response->getBody());
    }

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
            throw new Exception("Sms16 gateway error: login/password can not be empty");
        }

        // Установка данных
        $timestamp = $this->getTimestamp($client);
        $data = array(
            'login' => $this->getLogin(),
            'phone' => $message->getPhone(),
            'text' => $message->getText(),
            'timestamp' => $timestamp,
            'sender' => $this->getOriginator(),
            'return' => 'json'
        );
        $data['signature'] = $this->getSignature($data, $this->getPassword());

        $request = new \Zend\Http\Request();
        $request->setUri($this->getGatewayUrl());
        $request->setMethod(\Zend\Http\Request::METHOD_GET);
        $headers = new \Zend\Http\Headers();
        $request->setHeaders($headers);
        $parameters = new Parameters($data);
        $request->setQuery($parameters);

        $response = $client->send($request);

        $body = json_decode($response->getBody(), true);
        /**
         *   ["error"]=>
                string(1) "0"
            ["id_sms"]=>
                string(22) "4092112510348380960001"
            ["cost"]=>
                string(3) "0.5"
            ["count_sms"]=>
                string(1) "1"
         */
        if ($response->isSuccess()) {

            if (!empty($body['error'])) {
                throw new Exception("Ошибка при отправке запроса: " . $this->getErrorByCode($body['error']));
            } else {
                $data = array_shift($body);
                $data = array_shift($data);
                if (!isset($data['id_sms'])) {
                    throw new Exception("Ошибка при отправке запроса: " . $this->getErrorByCode($data['error']));
                }
                return $data['id_sms'];
            }
        } else {
            $error = 'Ошибка при отправке запроса';
            throw new Exception($error);
        }
    }

    /**
     * @param $code
     * @return string
     */
    protected function getErrorByCode($code) : string
    {
        $codes = [
            '000' => 'Сервис отключен',
            '1' => 'Не указана подпись',
            '2' => 'Не указан логин',
            '3'  => 'Не указан текст',
            '4'  => 'Не указан телефон',
            '5'  => 'Не указан отправитель',
            '6'  => 'Не корректная подпись',
            '7'  => 'Не корректный логин',
            '8'  => 'Не корректное имя отправителя',
            '9'  => 'Не зарегистрированное имя отправителя',
            '10' => 'Не одобренное имя отправителя',
            '11' => 'В тексте содержатся запрещенные слова',
            '12' => 'Ошибка отправки СМС',
            '13' => 'Номер находится в стоп-листе. Отправка на этот номер запрещена',
            '14' => 'В запросе более 50 номеров',
            '15' => 'Не указана база',
            '16' => 'Не корректный номер',
            '17' => 'Не указаны ID СМС',
            '18' => 'Не получен статус',
            '19' => 'Пустой ответ',
            '20' => 'Номер уже существует',
            '21' => 'Отсутствует название',
            '22' => 'Шаблон уже существует',
            '23' => 'Не указан месяц (Формат: YYYY-MM)',
            '24' => 'Не указана временная метка',
            '25' => 'Ошибка доступа к базе',
            '26' => 'База не содержит номеров',
            '27' => 'Нет валидных номеров',
            '28' => 'Не указана начальная дата',
            '29' => 'Не указана конечная дата',
            '30' => 'Не указана дата (Формат: YYYY-MM-DD)'
        ];
        return $codes[$code] ?? 'unknown error code: ' . $codes;
    }

    /**
     * @param array $params
     * @param string $apiKey
     * @return string
     */
    private function getSignature(array $params, string $apiKey) : string
    {
        ksort($params);
        reset($params);

        $signature = md5(join($params) . $apiKey);

        return $signature;
    }
}