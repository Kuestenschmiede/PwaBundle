<?php


namespace con4gis\PwaBundle\Command;


use con4gis\PwaBundle\Classes\Events\PushNotificationEvent;
use con4gis\PwaBundle\Entity\PushSubscription;
use Contao\System;
use Minishlink\WebPush\Subscription;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class SendPushNotificationCommand
 * Console command to send push notifications (to all subscribers). Can be used for debugging purposes.
 * @package con4gis\PwaBundle\Command
 */
class SendPushNotificationCommand extends Command
{
    protected static $defaultName = 'con4gis:send-push';
    
    private $container;
    
    private $webPush;
    
    /**
     * SendPushNotificationCommand constructor.
     * @param ContainerInterface $container
     * @param $webPush
     */
    public function __construct(ContainerInterface $container, $webPush)
    {
        parent::__construct();
        $this->container = $container;
        $this->webPush = $webPush;
    }
    
    protected function configure()
    {
        $this->setName('con4gis:send-push')
            ->addArgument('content', InputArgument::REQUIRED, 'Content of the push notification.')
            ->setDescription('Sends a push notification to all subscribers.')
        ;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $content = $input->getArgument('content');
        $title = "Neue Benachrichtigung";
        $eventDispatcher = $this->container->get('event_dispatcher');
        $event = new PushNotificationEvent();
        $event->setSendToAll(true);
        $event->setTitle($title);
        $event->setMessage($content);
        $eventDispatcher->dispatch($event::NAME, $event);
    }
    
}