<?php


namespace con4gis\PwaBundle\Classes\Listener;

use con4gis\PwaBundle\Classes\Events\PushNotificationEvent;
use con4gis\PwaBundle\Entity\PushSubscription;
use con4gis\PwaBundle\Entity\WebPushConfiguration;
use Contao\FilesModel;
use Doctrine\ORM\EntityManager;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class PushNotificationListener
{
    /**
     * @var EntityManager
     */
    private $entityManager = null;
    
    /**
     * @var WebPush
     */
    private $webPushService = null;
    
    /**
     * PushNotificationListener constructor.
     * @param null $entityManager
     * @param null $webPushService
     */
    public function __construct($entityManager, $webPushService)
    {
        $this->entityManager = $entityManager;
        $this->webPushService = $webPushService;
    }
    
    
    /**
     * Gets the subscriptions.
     * @param PushNotificationEvent $event
     * @param $eventName
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function onPushNotificationGetSubscriptions(
        PushNotificationEvent $event,
        $eventName,
        EventDispatcherInterface $eventDispatcher
    ) {
        if ($event->isSendToAll()) {
            $subscriptions = $this->entityManager->getRepository(PushSubscription::class)->findAll();
        } else {
            $subscriptions = $this->entityManager->getRepository(PushSubscription::class)->findBy(['endpoint' => $event->getEndpoints()]);
        }
        $event->setSubscriptions($subscriptions);
    }
    
    /**
     * Sends the notifications.
     * @param PushNotificationEvent $event
     * @param $eventName
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function onPushNotificationSendNotifications(
        PushNotificationEvent $event,
        $eventName,
        EventDispatcherInterface $eventDispatcher
    ) {
        $webpushConfig = $this->entityManager->getRepository(WebPushConfiguration::class)->findOnly();
        $filePath = FilesModel::findByUuid($webpushConfig->getIcon())->path;
        $content = \GuzzleHttp\json_encode([
            'title' => $event->getTitle(),
            'body' => $event->getMessage(),
            'icon' => $filePath
        ]);
        
        $subscriptions = $event->getSubscriptions();
        foreach ($subscriptions as $subscription) {
            try {
                $sub = Subscription::create([
                    'endpoint' => $subscription->getEndpoint(),
                    'contentEncoding' => "aesgcm",
                    'publicKey' => $subscription->getP256dhKey(),
                    'authToken' => $subscription->getAuthKey()
                ]);
            } catch (\ErrorException $exception) {
                // TODO catch exception
            }
            
            $res = $this->webPushService->sendNotification($sub, $content);
            $reports = $this->webPushService->flush();
            if (is_array($reports)) {
                foreach ($reports as $report) {
                    $endpoint = $report['endpoint']->getHost() . $report['endpoint']->getPath();
//                    if ($report['success']) {
//                        $output->writeln("[v] Message sent successfully for subscription {$endpoint}.");
//                    } else {
//                        $output->writeln("[x] Message failed to sent for subscription {$endpoint}: {$report['message']}");
//                    }
                }
            }
        }
    }
}