<?php
/**
 * @package   Zenomania\CoreBundle/Service/Sms
 * @author    miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */
/**
 * @namespace
 */
namespace Zenomania\CoreBundle\Service\Sms\Queue;

use Zenomania\CoreBundle\Service\Sms;

class StrategyQueue
{
    /**
     * Sms gateway
     *
     * @var Sms\Gateway\AbstractGateway
     */
    protected $gateway;
    /**
     * Client interface
     *
     * @var Sms\Client
     */
    protected $client;

    /**
     * @return \Zenomania\CoreBundle\Service\Sms\Client
     */
    public function getClient()
    {
        if(null === $this->client) {
            $this->client = new Sms\Client($this->getGateway());
        }
        return $this->client;
    }
    /**
     * @param \Zenomania\CoreBundle\Service\Sms\Gateway\AbstractGateway $gateway
     */
    public function setGateway($gateway)
    {
        $this->gateway = $gateway;
    }

    /**
     * @return \Zenomania\CoreBundle\Service\Sms\Gateway\AbstractGateway
     */
    public function getGateway()
    {
        return $this->gateway;
    }
    /**
     * Build strategy object according to gateway
     *
     * @param \Zenomania\CoreBundle\Service\Sms\Gateway\AbstractGateway $gateway
     */
    public function __construct(Sms\Gateway\AbstractGateway $gateway)
    {
        $this->gateway = $gateway;
    }
    /**
     * Choose valid gateway and send message through it
     *
     * @param $data
     * @return mixed
     */
    public function send($data)
    {
        $client = $this->getClient();
        $message = new Sms\Message();
        $message->setPhone($data['phone'])
            ->setText($data['text']);
        $gateway = $this->getGateway();
        $gateway->setFromArray($data);

        $message->translit = $data['use_translit'];

        return $client->send($message);
    }
}
