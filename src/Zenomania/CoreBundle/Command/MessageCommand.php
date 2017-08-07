<?php
/**
 * @package    Zenomania\CoreBundle\Command
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */

namespace Zenomania\CoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Zenomania\CoreBundle\Service\Sms\Client;

/**
 * SMS Message command
 */
class MessageCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('sms:send')
            ->setDescription('Send sms message')
            ->addArgument(
                'phone',
                InputArgument::REQUIRED,
                'Phone to send message'
            )
            ->addArgument(
                'message',
                InputArgument::OPTIONAL,
                'Message to send'
            )
            ->addOption(
                'client',
                'c',
                InputOption::VALUE_REQUIRED,
                'Client that is used to send messages',
                'default'
            );
    }

    /**
     * Send message
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     * @throws Client\Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $text = $input->getArgument('message');
        if (empty($text)) {
            $text = $this->getRandomMessage();
        }

        $clientName = $input->getOption('client');
        /** @var Client $client */
        $client = $this->getContainer()->get(sprintf('sms_service.%s', $clientName));

        $message = new \Zenomania\CoreBundle\Service\Sms\Message();
        $message->setPhone($input->getArgument('phone'));
        $message->setText($text);

        $id = $client->send($message);
        $output->writeln(sprintf("<info>Message sent. Id: %s</info>", $id));
    }

    /**
     * @return string
     */
    private function getRandomMessage()
    {
        $messages = [
            'Lorem ipsum dolor sit amet',
            'consectetuer adipiscing elit',
            'Aenean commodo ligula eget dolor.',
            'Aenean massa.',
            'Cum sociis natoque penatibus et magnis dis parturient montes',
            'nascetur ridiculus mus',
            'Nulla consequat massa quis enim.',
            'Nullam dictum felis eu pede mollis pretium.'
        ];
        return $messages[rand(0, count($messages)-1)];
    }
}