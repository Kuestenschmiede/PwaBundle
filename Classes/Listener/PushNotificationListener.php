<?php
/*
 * This file is part of con4gis,
 * the gis-kit for Contao CMS.
 *
 * @package   	con4gis
 * @version    6
 * @author  	con4gis contributors (see "authors.txt")
 * @license 	LGPL-3.0-or-later
 * @copyright 	Küstenschmiede GmbH Software & Design
 * @link       https://www.con4gis.org
 */

namespace con4gis\PwaBundle\Classes\Listener;

use con4gis\PwaBundle\Classes\Events\PushNotificationEvent;
use con4gis\PwaBundle\Entity\PushSubscription;
use con4gis\PwaBundle\Entity\WebPushConfiguration;
use Contao\FilesModel;
use Doctrine\ORM\EntityManager;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;
use Psr\Log\LoggerInterface;
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
     * @var LoggerInterface
     */
    private $logger = null;
    
    /**
     * PushNotificationListener constructor.
     * @param $entityManager
     * @param $webPushService
     * @param LoggerInterface $logger
     */
    public function __construct($entityManager, $webPushService, LoggerInterface $logger)
    {
        $this->entityManager = $entityManager;
        $this->webPushService = $webPushService;
        $this->logger = $logger;
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
        $types = $event->getSubscriptionTypes();
        $subscriptions = $this->entityManager->getRepository(PushSubscription::class)->findAll();
        $resSubscriptions = [];
        if (count($types) > 0) {
            foreach ($subscriptions as $subscription) {
                if (array_intersect($types, $subscription->getTypes())) {
                    $resSubscriptions[] = $subscription;
                }
            }
        } else {
            $resSubscriptions = $subscriptions;
        }
        $event->setSubscriptions($resSubscriptions);
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
                $res = $this->webPushService->sendNotification($sub, $content);
                $reports = $this->webPushService->flush();
            } catch (\ErrorException $exception) {
                // log error message with stack trace
                $this->logger->error($exception->getMessage() . "\n" . $exception->getTrace());
            }
        }
    }
}