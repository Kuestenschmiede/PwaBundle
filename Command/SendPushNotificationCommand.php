<?php


namespace con4gis\PwaBundle\Command;


use con4gis\PwaBundle\Entity\PushSubscription;
use Contao\System;
use Minishlink\WebPush\Subscription;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SendPushNotificationCommand extends Command
{
    protected static $defaultName = 'con4gis:send-push';
    
    private $container;
    
    private $webPush;
    
    /**
     * SendPushNotificationCommand constructor.
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
        $content = \GuzzleHttp\json_encode([
            'title' => "Test",
            'body' => $content
        ]);
        $entityManager = $this->container->get('doctrine.orm.default_entity_manager');
        $subscriptions = $entityManager->getRepository(PushSubscription::class)->findAll();
        foreach ($subscriptions as $subscription) {
            $sub = Subscription::create([
                'endpoint' => $subscription->getEndpoint(),
                'contentEncoding' => "aesgcm",
                'publicKey' => $subscription->getP256dhKey(),
                'authToken' => $subscription->getAuthKey()
            ]);
            $res = $this->webPush->sendNotification($sub, $content);
            $reports = $this->webPush->flush();
            if (is_array($reports)) {
                foreach ($reports as $report) {
                    $endpoint = $report->getRequest()->getUri()->__toString();
                    if ($report->isSuccess()) {
                        $output->writeln("[v] Message sent successfully for subscription {$endpoint}.");
                    } else {
                        $output->writeln("[x] Message failed to sent for subscription {$endpoint}: {$report->getReason()}");
                    }
                }
            }
        }
    
        
    }
    
}